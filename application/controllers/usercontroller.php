<?php


namespace Framework\controllers;


use Framework\lib\AbstractController;
use Framework\lib\Redirect;
use Framework\Lib\Session;
use Framework\models\MemorialsModel;

class UserController extends AbstractController
{
    public function DefaultAction()
    {
        Redirect::To('user/memorials');
    }

    public function MemorialsAction()
    {
        $memorial = MemorialsModel::GetMemorialsWithPhoto("WHERE memorials.createdBy = '".Session::Get('loggedin')->id."'");
        $this->_template->SetData(['memorials' => $memorial])
            ->SetViews(['header', 'view'])
            ->Render();
    }

    public function VisitsAction()
    {
        $memorials = MemorialsModel::GetVisitedMemorials(Session::Get('loggedin')->id);
        $this->_template->SetData(['memorials' => $memorials])
            ->SetViews(['header', 'view'])
            ->Render();
    }

    public function SignoutAction()
    {
        Session::Remove('loggedin');
        header("location: " . HOST_NAME . 'login');
    }
}