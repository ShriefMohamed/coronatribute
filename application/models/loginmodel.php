<?php


namespace Framework\models;


use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Framework\lib\Cipher;
use Framework\lib\FilterInput;
use Framework\lib\Helper;
use Framework\lib\Request;
use Framework\lib\Session;
use Framework\lib\Text;
use Google_Client;

class LoginModel
{
    public static function Login($username, $password)
    {
      if ($username && $password) {
          // check first to decide if this value is
          // email or phone or username and filter it with the appropriate filtering method.
          if ((FilterInput::Email(Request::Post('username')))) {
              $username = FilterInput::Email($username);
          } elseif (FilterInput::Int(Request::Post('username'))) {
              $username = FilterInput::Int($username);
          } else {
              $username = FilterInput::String($username);
          }
          // get the password from the user.
          // hash the password to compare hashes.
          $password = Helper::HashPassword($password);

          // send the username and password to usersmodel to check if there's a user with these credentials.
          $authentication = UsersModel::Authenticate($username, $password);
          if ($authentication !== false) {
              // if authentication was successful then:
              // remove password from the object before putting it into a session
              unset($authentication->password);
              // set a session with the user details.
              Session::Set('loggedin', $authentication);
              return true;
          } else {
              return false;
          }
      } else {
          return false;
      }
    }

    public static function Register()
    {
        $response = '';

        $item = new UsersModel();
        $item->firstName = FilterInput::String(Request::Post('register-firstName', false, true));
        $item->lastName = FilterInput::String(Request::Post('register-lastName', false, true));
        $item->username = FilterInput::String(Request::Post('register-username', false, true));
        $item->email = FilterInput::Email(Request::Post('register-email', false, true));
        $item->password = Helper::HashPassword(Request::Post('register-password', false, false));
        $item->role = 'user';

        $usernameCheck = UsersModel::Count(" WHERE username = '$item->username'");
        $emailCheck = UsersModel::Count(" WHERE email = '$item->email'");
        if ($usernameCheck >= 1) {
            $response = "Failed to create account, username already taken!";
        } elseif ($emailCheck >= 1) {
            $response = "Failed to create account, email already taken, Try login instead or try reset password if you forgot your password";
        } else {
            if ($item->Save() && $item->id) {
                // send welcome email..
                unset($item->password);
                Session::Set('loggedin', $item);
                $response = 1;
            } else {
                $response = "Failed to create account, Unknown error!";
            }
        }

        return $response;
    }

    public static function GoogleLogin($id_token)
    {
        $response = false;
        if ($id_token) {
            $client = new Google_Client(['client_id' => GOOGLE_CLIENT_ID]);
            $client->setScopes('email');
            $client->setAccessType('offline');
            $client->setApprovalPrompt('force');

            $payload = $client->verifyIdToken($id_token);

            if ($payload) {
                $userid = $payload['sub'];

                $check_user = UsersModel::GetAll("WHERE api_userID = '$userid' || email = '".$payload['email']."'", false, true);

                $user = new UsersModel();
                if ($check_user) {
                    $user->id = $check_user->id;
                }
                $user->api = 'google';
                $user->api_userID = $userid;
                $user->firstName = $payload['given_name'];
                $user->lastName = $payload['family_name'];
                $user->email = $payload['email'];
                $user->role = 'user';
                if (isset($payload['picture']) && !empty($payload['picture'])) {
                    $user->imageType = 2;
                    $user->image = $payload['picture'];
                }

                if ($user->Save() && $user->id) {
                    $cipher = new Cipher();

                    Session::Set('loggedin', $user);
                    Session::SetCookie('gtoken', $cipher->Encrypt($id_token), 168);
                    $response = $user->id;
                }
            }
        }
        return $response;
    }

    /*
    show more
    create memo link everywhere
    profile settings
    */

    private static function FacebookHelper()
    {
        $fb = new Facebook([
            'app_id' => FACEBOOK_APP_ID,
            'app_secret' => FACEBOOK_APP_SECRET,
            'default_graph_version' => 'v3.2',
        ]);
        return $fb;
    }

    public static function Facebook_generate_login($callback)
    {
        $fb = self::FacebookHelper();
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email']; // Optional permissions
        $callbackUrl = htmlspecialchars(HOST_NAME . $callback);
        return $helper->getLoginUrl($callbackUrl, $permissions);
    }

    public static function Facebook_login()
    {
        $fb = self::FacebookHelper();
        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(FacebookResponseException $e) {
            // When Graph returns an error
            return 'Graph returned an error: ' . $e->getMessage();
        } catch(FacebookSDKException $e) {
            // When validation fails or other local issues
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }

        if (! isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        // Logged in. Access Token: $accessToken->getValue()

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);

        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId(FACEBOOK_APP_ID);

        // If you know the user ID this access token belongs to, you can validate it here
        //$tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();

        if (! $accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (FacebookSDKException $e) {
                return "Error getting long-lived access token: " . $e->getMessage();
            }
        }

        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get('/me?fields=id,first_name,last_name,email,picture', $accessToken);
        } catch(FacebookResponseException $e) {
            return 'Graph returned an error: ' . $e->getMessage();
        } catch(FacebookSDKException $e) {
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }

        $user = $response->getGraphUser();


        $user_id = $user['user_id'];
        $check_user = UsersModel::GetAll("WHERE api_userID = '$user_id' || email = '".$user['email']."'", false, true);

        $item = new UsersModel();
        if ($check_user) {
            $user->id = $check_user->id;
        }
        $item->api = 'facebook';
        $item->api_userID = $user_id;
        $item->firstName = $user['first_name'];
        $item->lastName = $user['last_name'];
        $item->email = $user['email'];
        $item->role = 'user';
        if (isset($payload['picture']) && !empty($payload['picture'])) {
            $item->imageType = 2;
            $item->image = $user['picture']['url'];
        }

        if ($item->Save() && $item->id) {
            $cipher = new Cipher();

            Session::Set('loggedin', $item);
            Session::SetCookie('ftoken', $cipher->Encrypt($accessToken), 168);
            return array('status' => true);
        } else {
            return Text::Get("UNKNOWN_ERROR");
        }

    }
}