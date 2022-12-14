<?php
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    public function login(Request $request)
    {
        $loginForm = new LoginForm();

        if($request->isPost()) {
            $loginForm->loadData($request->getBody());
            if($loginForm->validate() && $loginForm->login()) {
                Application::$app->response->redirect('/');
                exit;
            }
        }

        $this->setLayout('auth');
        return $this->reder('login', [
            'model' => $loginForm
        ]);
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
        }

        return $this->reder('register', [
            'model' => $user
        ]);
    }

    public function logout(Request $request)
    {
        Application::$app->logout();
        Application::$app->response->redirect('/');
    }

    public function profile()
    {
        return $this->reder('profile');
    }
}