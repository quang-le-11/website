<?php
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\User;

class AuthController extends Controller
{
    public function login()
    {
        $this->setLayout('auth');

        return $this->reder('login');
    }

    public function register(Request $request)
    {

        $user = new User();

        if($request->isPost()) {
            $user->loadData($request->getBody());
           
            if($user->validate() && $user->save()) {
                Application::$app->session->setFlash('success', 'Thanks for registering');
                Application::$app->response->redirect('/');
                exit;
            }
          
            return $this->reder('register', [
                'model' => $user
            ]);
        }

        return $this->reder('register', [
            'model' => $user
        ]);
    }
}