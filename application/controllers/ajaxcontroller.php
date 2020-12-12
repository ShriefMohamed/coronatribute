<?php


namespace Framework\controllers;


use Framework\lib\AbstractController;
use Framework\lib\FilterInput;
use Framework\lib\Helper;
use Framework\lib\Request;
use Framework\lib\Session;
use Framework\lib\Text;
use Framework\models\LoginModel;
use Framework\models\Memorial_photosModel;
use Framework\models\Memorial_storiesModel;
use Framework\models\Memorial_tributesModel;
use Framework\models\Memorial_visitsModel;
use Framework\models\MemorialsModel;
use Framework\models\UsersModel;

class AjaxController extends AbstractController
{
    private function UpdateMemorial()
    {
        $id = Session::Get('memorial')->id;
        $user_id = Session::Get('loggedin')->id;
        if ($id && is_numeric($id) && $user_id && is_numeric($user_id)) {
            $memorial = new MemorialsModel();
            $memorial->id = $id;
            $memorial->createdBy = $user_id;
            return $memorial->Save() ? true : false;
        }
        return false;
    }

    /* Create Memorial */
    public function Check_webaddressAction()
    {
        $address = isset($this->_params) ? $this->_params[0] : false;
        if ($address != false) {
            $result = MemorialsModel::Count("WHERE webAddress = '$address'");
            die(json_encode($result));
        }
    }

    public function Memorial_create_actionAction()
    {
        $item = new MemorialsModel();
        $item->firstName = FilterInput::String(Request::Post('firstName'));
        $item->lastName = FilterInput::String(Request::Post('lastName'));
        $item->nickName = FilterInput::String(Request::Post('nickname'));
        $item->gender = Request::Post('gender');
        $item->relationship = FilterInput::String(Request::Post('relationship'));
        $item->relationship_other = ($item->relationship == 'Other') ? FilterInput::String(Request::Post('relationship-other')) : '';
        $item->birthDate = Request::Post('birthdate') ? date('Y-m-d', strtotime(Request::Post('birthdate'))) : '';
        $item->birthCountry = FilterInput::String(Request::Post('birth-country'));
        $item->birthState = FilterInput::String(Request::Post('birth-state'));
        $item->passingDate = Request::Post('passing-date') ? date('Y-m-d', strtotime(Request::Post('passing-date'))) : '';
        $item->passingCountry = FilterInput::String(Request::Post('passing-country'));
        $item->passingState = FilterInput::String(Request::Post('passing-state'));
        $item->webAddress = FilterInput::String(Request::Post('web-address'));
        $item->epithet = "Let the memory of $item->firstName be with us forever.";
        if (Request::Check('loggedin-user')) {
            $item->createdBy = FilterInput::Int(Request::Post('loggedin-user'));
        }

        if ($item->Save() && $item->id) {
            Session::Set('memorial', $item);
            $response = array('status' => 1, 'id' => $item->id);
        } else {
            $response = array('status' => 0, 'msg' => 'Error');
        }

        die(json_encode($response));
    }

    public function Memorial_registerAction()
    {
        $memorialId = isset($this->_params) ? $this->_params[0] : false;
        if (Request::Check('register-email') && Request::Check('register-password')) {
            $response = LoginModel::Register();
            if ($response == 1) {
                if (!$this->UpdateMemorial()) {
                    $response = Text::Get('MEMORIAL_LOGIN_UPDATE_FAILED');
                } else {
                    Session::Remove('memorial');
                }
            }

            die(json_encode($response));
        }
    }

    public function Memorial_loginAction()
    {
        $memorialId = isset($this->_params) ? $this->_params[0] : false;
        if (Request::Check('login-email') && Request::Check('login-password')) {
            $response = '';
            $username = Request::Post('login-email', false, true);
            $password = Request::Post('login-password', false, true);

            if (LoginModel::Login($username, $password)) {
                if ($this->UpdateMemorial()) {
                    Session::Remove('memorial');
                    $response = 1;
                } else {
                    $response = Text::Get('MEMORIAL_LOGIN_UPDATE_FAILED');
                }
            } else {
                $response = 'Invalid Credentials!';
            }

            die(json_encode($response));
        }
    }

    public function Memorial_google_loginAction()
    {
        $response = '';
        if (Request::Check('idtoken')) {
            $id_token = $_POST['idtoken'];
            $memorial_id = $_POST['memorialId'];

            $auth = LoginModel::GoogleLogin($id_token);
            if ($auth !== false && is_numeric($auth)) {
                if ($this->UpdateMemorial()) {
                    Session::Remove('memorial');
                    $response = 1;
                } else {
                    $response = Text::Get('MEMORIAL_LOGIN_UPDATE_FAILED');
                }
            }
        } else {
            $response = 'Error!';
        }
        die(json_encode($response));
    }

    public function FacebookAction()
    {
        $facebook_login_url = LoginModel::Facebook_generate_login('ajax/memorial_facebook_login/');
        header("location: ". $facebook_login_url);
    }

    public function Memorial_facebook_loginAction()
    {
        $auth = LoginModel::Facebook_login();
        if ($auth && is_array($auth) && $auth['status'] == true) {
            if ($this->UpdateMemorial()) {
                $webAddress = Session::Get('memorial')->webAddress;
                Session::Remove('memorial');
                header("location" . Helper::MemorialWebAddress($webAddress));
            } else {
                Session::Set('memorial-login-error', Text::Get('MEMORIAL_LOGIN_UPDATE_FAILED'));
            }
        } else {
            Session::Set('memorial-login-error', Text::Get('LOGIN_FAILED'));
        }
    }
    /* End Create Memorial */


    /* Memorial */
    private function Upload($memorialId, $userId) {
        if ($memorialId) {
            $preview = $config = $errors = [];
            $input = 'photos'; // the input name for the fileinput plugin
            if (empty($_FILES[$input])) {
                return [];
            }

            $total = count($_FILES[$input]['name']); // multiple files
            $path = MEMORIAL_PHOTOS_DIR . $memorialId . DS;
            if (!file_exists($path)) {
                mkdir(MEMORIAL_PHOTOS_DIR . $memorialId, 0777, true);
            }
            for ($i = 0; $i < $total; $i++) {
                $tmpFilePath = $_FILES[$input]['tmp_name'][$i]; // the temp file path
                $fileName = rand(99999999, 9) . '.' . $_FILES[$input]['name'][$i]; // the file name
                $fileSize = $_FILES[$input]['size'][$i]; // the file size

                //Make sure we have a file path
                if ($tmpFilePath != "") {
                    //Setup our new file path
                    $newFilePath = $path . $fileName;
                    $newFileUrl = MEMORIAL_PHOTOS_PATH . $memorialId . DS . $fileName;

                    //Upload the file into the new path
                    if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                        $memorial_photo = new Memorial_photosModel();
                        $memorial_photo->memorial_id = $memorialId;
                        $memorial_photo->name = $fileName;
                        $memorial_photo->createdBy = $userId;

                        if ($memorial_photo->Save() && $memorial_photo->id) {
                           $preview[] = "<img src='$newFileUrl'>";
                           $config[] = [
                               'key' => $memorial_photo->id,
                               'caption' => $fileName,
                               'size' => $fileSize,
                               'downloadUrl' => $newFileUrl, // the url to download the file
                               'url' => HOST_NAME . 'ajax/memorial_item_delete/gallery/'.$memorialId, // server api to delete the file based on key
                           ];
                        } else {
                           unlink($newFilePath);
                           $errors[] = $fileName;
                        }
                    } else {
                        $errors[] = $fileName;
                    }
                } else {
                    $errors[] = $fileName;
                }
            }

            $out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config, 'initialPreviewAsData' => true];
            if (!empty($errors)) {
                $img = count($errors) === 1 ? 'file "' . $errors[0]  . '" ' : 'files: "' . implode('", "', $errors) . '" ';
                $out['error'] = 'Oh snap! We could not upload the ' . $img . 'now. Please try again later.';
            }
            return $out;
        }
    }

    private function Memorial_delete($id)
    {
        if ($id !== false) {
            $memorial = new MemorialsModel();
            $memorial->id = $id;
            if ($memorial->Delete()) {
                $where = "WHERE memorial_id = '$id'";

                $stories = new Memorial_storiesModel();
                $stories->Delete($where);
                $tributes = new Memorial_tributesModel();
                $tributes->Delete($where);
                $visits = new Memorial_visitsModel();
                $visits->Delete($where);

                return true;
            }
            return false;
        }
    }


    public function Memorial_authAction()
    {
        $id = isset($this->_params) ? $this->_params[0] : false;
        $response = array('status' => 0, 'msg' => Text::Get("UNKNOWN_ERROR"));
        if (Request::Post('email') && $id && Session::Exists('loggedin')) {
            $memorial = MemorialsModel::GetOne($id);
            if ($memorial) {
                if ($memorial->createdBy == Session::Get('loggedin')->id) {
                    $authentication = UsersModel::GetAll("WHERE id = " . Session::Get('loggedin')->id . " && email = '" . Request::Post('email') . "'", false, true);
                    if ($authentication) {
                        if ($this->Memorial_delete($id)) {
                            $response = array('status' => 1, 'msg' => 'Memorial was deleted successfully.');
                        } else {
                            $response = array('status' => 0, 'msg' => 'Failed to delete memorial, try again later!');
                        }
                    } else {
                        $response = array('status' => 0, 'msg' => Text::Get('AUTHENTICATION_FAILED'));
                    }
                }
            }
        }

        die(json_encode($response));
    }

    public function Memorial_about_editAction()
    {
        $id = isset($this->_params) ? $this->_params[0] : false;
        if ($id !== false && Session::Exists('loggedin')) {
            $memorial = MemorialsModel::GetOne($id);
            if ($memorial) {
                if ($memorial->createdBy == Session::Get('loggedin')->id) {
                    $item = new MemorialsModel();
                    $item->id = $id;
                    $item->firstName = FilterInput::String(Request::Post('firstName'));
                    $item->lastName = FilterInput::String(Request::Post('lastName'));
                    $item->nickName = FilterInput::String(Request::Post('nickname'));
                    $item->relationship = FilterInput::String(Request::Post('relationship'));
                    $item->relationship_other = ($item->relationship == 'Other') ? FilterInput::String(Request::Post('relationship-other')) : '';
                    $item->birthDate = Request::Post('birthdate') ? date('Y-m-d', strtotime(Request::Post('birthdate'))) : '';
                    $item->birthCountry = FilterInput::String(Request::Post('birth-country'));
                    $item->birthState = FilterInput::String(Request::Post('birth-state'));
                    $item->passingDate = Request::Post('passing-date') ? date('Y-m-d', strtotime(Request::Post('passing-date'))) : '';
                    $item->passingCountry = FilterInput::String(Request::Post('passing-country'));
                    $item->passingState = FilterInput::String(Request::Post('passing-state'));

                    if ($item->Save()) {
                        $response = array('status' => 1);
                    } else {
                        $response = array('status' => 0, 'msg' => 'Error');
                    }
                } else {
                    $response = array('status' => 0, 'msg' => 'You don\'t have permission.');
                }
            } else {
                $response = array('status' => 0, 'msg' => 'Not found!');
            }

            die(json_encode($response));
        }
    }

    public function Memorial_biography_addAction()
    {
        $memorialId = isset($this->_params) ? $this->_params[0] : false;
        if ($memorialId !== false && !empty($_POST['biography']) && Session::Exists('loggedin')) {
            $item = new Memorial_storiesModel();
            $item->memorial_id = $memorialId;
            $item->createdBy = Session::Get('loggedin')->id;
            $item->story = htmlentities($_POST['biography'], ENT_QUOTES, 'UTF-8');

            if ($item->Save() && $item->id) {
                $response = array('status' => 1, 'id' => $item->id, 'story' => html_entity_decode($item->story));
            } else {
                $response = array('status' => 0, 'msg' => 'Error');
            }

            die(json_encode($response));
        }
    }

    public function Memorial_biography_editAction()
    {
        $id = Request::Check('story-id') ? Request::Post('story-id') : false;
        if ($id !== false && !empty($_POST['biography']) && Session::Exists('loggedin')) {
            $story = Memorial_storiesModel::GetOne($id);
            if ($story) {
                if ($story->createdBy == Session::Get('loggedin')) {
                    $item = new Memorial_storiesModel();
                    $item->id = $id;
                    $item->story = htmlentities($_POST['biography'], ENT_QUOTES, 'UTF-8');

                    if ($item->Save()) {
                        $response = array('status' => 1, 'id' => $item->id, 'story' => html_entity_decode($item->story));
                    } else {
                        $response = array('status' => 0, 'msg' => 'Error');
                    }
                } else {
                    $response = array('status' => 0, 'msg' => 'You don\'t have permission.');
                }
            } else {
                $response = array('status' => 0, 'msg' => 'Not found!');
            }

            die(json_encode($response));
        }
    }


    public function Memorial_tribute_addAction()
    {
        $memorialId = isset($this->_params) ? $this->_params[0] : false;
        if ($memorialId !== false && !empty($_POST['tribute']) && Session::Exists('loggedin')) {
            $item = new Memorial_tributesModel();
            $item->memorial_id = $memorialId;
            $item->createdBy = Session::Get('loggedin')->id;
            $item->tribute = htmlentities($_POST['tribute'], ENT_QUOTES, 'UTF-8');

            if ($item->Save() && $item->id) {
                $response = array('status' => 1, 'id' => $item->id, 'tribute' => html_entity_decode($item->tribute));
            } else {
                $response = array('status' => 0, 'msg' => 'Error');
            }

            die(json_encode($response));
        }
    }


    public function Memorial_photos_addAction()
    {
        $memorialId = isset($this->_params) ? $this->_params[0] : false;
        if (Session::Exists('loggedin')) {
            $userId = Session::Get('loggedin')->id;
            $result = $this->Upload($memorialId, $userId);
            die(json_encode($result));
        }
    }

    public function Memorial_photo_featureAction()
    {
        $photo_id = isset($this->_params) ? $this->_params[0] : false;
        $featured = isset($this->_params) && isset($this->_params[1]) && $this->_params[1] ? $this->_params[1] : '1';

        $response = 0;
        if ($photo_id) {
            $item = new Memorial_photosModel();
            $item->id = $photo_id;
            $item->feature = $featured == '1' ? 2 : 1;
            $item->updated = date('Y-m-d h:i:s');
            if ($item->Save()) {
                $response = 1;
            } else {
                $response = 'Error';
            }
        }

        die(json_encode($response));
    }


    public function Memorial_item_deleteAction()
    {
        $type = isset($this->_params) ? $this->_params[0] : false;
        $memorial_id = isset($this->_params) && isset($this->_params[1]) && $this->_params[1] ? $this->_params[1] : false;
        if (Request::Check('key')) {
            $id = Request::Post('key');
        } else {
            $id = isset($this->_params) && isset($this->_params[2]) && $this->_params[2] ? $this->_params[2] : false;
        }

        if ($id !== false && $type !== false && $memorial_id !== false && Session::Exists('loggedin')) {
            $memorial = MemorialsModel::GetOne($memorial_id);
            $response = 0;

            switch ($type) {
                case 'biography':
                    $original_item = Memorial_storiesModel::GetOne($id);
                    $item = new Memorial_storiesModel();
                    break;
                case 'tribute':
                    $original_item = Memorial_tributesModel::GetOne($id);
                    $item = new Memorial_tributesModel();
                    break;
                case 'gallery':
                    $original_item = Memorial_photosModel::GetOne($id);
                    $item = new Memorial_photosModel();
                    break;
                default:
                    $item = false;
                    $response = 'Unknown Type!';
            }

            if ($item !== false && isset($original_item) && $memorial) {
                if (($original_item->createdBy == Session::Get('loggedin')->id) || ($memorial->createdBy == Session::Get('loggedin')->id)) {
                    $item->id = $id;
                    if ($item->Delete()) {
                        $response = 1;
                    } else {
                        $response = 'Error deleting item!';
                    }
                }
            }

            die(json_encode($response));
        }
    }



    public function Memorial_visitAction()
    {
        $id = isset($this->_params) ? $this->_params[0] : false;
        if ($id !== false) {
            // record view if cookie doesn't exist or exists but for another memorial
            if (!Session::CookieExists('memorial-' . $id)) {
                Session::SetCookie('memorial-' . $id, '', 24);
                $views = MemorialsModel::GetMemorialViews($id);
                $memorial = new MemorialsModel();
                $memorial->id = $id;
                $memorial->views = $views->views + 1;
                $memorial->Save();
            }

            // record visit for user to sync to his account later
            $visits = Session::GetCookie('visits');
            $visits[] = $id;

            if (!Session::Exists('loggedin')) {
                Session::SetCookie('visits', $visits, 720);
            }

            if (Session::Exists('loggedin')) {
                $user_id = Session::Get('loggedin')->id;
                foreach ($visits as $visit) {
                    $check_ownership = MemorialsModel::Count("WHERE id = '$visit' && createdBy = '$user_id'");
                    if (!$check_ownership) {
                        $check_visit = Memorial_visitsModel::GetAll("WHERE memorial_id = '$visit' && user_id = '$user_id'", false, true);

                        $memorial_visit = new Memorial_visitsModel();
                        if ($check_visit) {
                            $memorial_visit->id = $check_visit->id;
                            $memorial_visit->lastVisit = date('Y-m-d h:i:s');
                            $memorial_visit->visits = $check_visit->visits + 1;
                        } else {
                            $memorial_visit->memorial_id = $visit;
                            $memorial_visit->user_id = $user_id;
                        }
                        $memorial_visit->Save();
                    }
                }
                Session::SetCookie('visits', $visits, -1);
            }
        }

        die();
    }
    /* End Memorial */
}