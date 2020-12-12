<?php

namespace Framework\controllers;

use Framework\lib\AbstractController;
use Framework\lib\Cipher;
use Framework\lib\Redirect;
use Framework\lib\Request;
use Framework\lib\Session;
use Framework\lib\Text;
use Framework\models\LoginModel;

class LoginController extends AbstractController
{
    public function DefaultAction()
    {
        // make sure that there's a post request. if not then display the page normally.
        // check which form was submitted!
        if (Request::Check('login')) {
            $username = Request::Post('username', false, true);
            $password = Request::Post('password', false, true);

            if (LoginModel::Login($username, $password) !== false) {
                Redirect::ReturnURL();
            } else {
                // if login failed then display error message and log the attempt to the log file.
                Session::Set('login-message', Text::Get('INVALID_LOGIN_CREDENTIALS'));
            }
        }

        if (Request::Check('register')) {
            $register = LoginModel::Register();
            if ($register == 1) {
                Redirect::ReturnURL();
            } else {
                // if login failed then display error message.
                Session::Set('login-message', $register);
            }
        }

        if (Request::Check('forgot')) {

        }


        $this->_template->SetData([])
            ->SetViews(['header', 'view'])
            ->Render();
    }

    public function Google_loginAction()
    {
        $response = '';
        if (Request::Check('idtoken')) {
            $id_token = $_POST['idtoken'];

            $auth = LoginModel::GoogleLogin($id_token);
            if ($auth !== false && is_numeric($auth)) {
                $response = 1;
            }
        } else {
            $response = 'Error!';
        }
        die(json_encode($response));
    }

    public function Google_refresh_loginAction()
    {
        $response = 0;
        if (Session::CookieExists('gtoken')) {
            $cipher = new Cipher();

            $token = Session::GetCookie('gtoken');
            $token = $cipher->Decrypt($token);
            $auth = LoginModel::GoogleLogin($token);
            if ($auth !== false && is_numeric($auth)) {
                $response = 1;
            }
        }
        die(json_encode($response));
    }


    public function FacebookAction()
    {
        $facebook_login_url = LoginModel::Facebook_generate_login('login/facebook_login');
        header("location: ". $facebook_login_url);
    }

    public function Facebook_loginAction()
    {
        $auth = LoginModel::Facebook_login();
        if ($auth && is_array($auth) && $auth['status'] == true) {
            Redirect::ReturnURL();
        } else {
            Session::Set('login-message', "Login failed, " . $auth);
        }
    }

    private function ActivationString($email)
    {
        $random = substr(md5(mt_rand()), 0, 32);
        $cipher = new Cipher;
        $activation = $cipher->Encrypt($random . $email);;
        return $activation;
    }

    /*@TODO
     * Create the forget password method to enable users to reset passwords
     * */
    public function Forgot_passwordAction()
    {

    }
}