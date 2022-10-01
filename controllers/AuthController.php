<?php
namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class AuthController extends Controller
{
    public function login()
    {
        $this->setLayout('auth');

        return $this->reder('login');
    }

    public function register(Request $request)
    {
        if($request->isPost()) {
            return 'Submit data';
        }
        $this->setLayout('auth');
        
        return $this->reder('register');
    }
}