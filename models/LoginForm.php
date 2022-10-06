<?php

namespace app\models;

use app\core\Application;
use app\core\Model;

class LoginForm extends Model
{
    public string $email = '';
    public string $password = '';

    public function rules(): array
    {
       return [
           'email' => [self::RULES_REQUIRED, self::RULES_EMAIL],
           'password' => [self::RULES_REQUIRED]
       ];
    }

    public function labels(): array
    {
        return [
            'email' => 'Email',
            'password' => 'Password'
        ];
    }

    public function login()
    {
        $user = User::findOne(['email' => $this->email]);
        if(!$user) {
            $this->addError('email', 'User does not exits with this email');
            return false;
        }
        if (password_verify($this->password, $user->password)) {
            echo '<pre>';
            var_dump($user->password);
            echo '</pre>';
            $this->addError('password', 'Password is incorrect');
            return false;
        }
        return Application::$app->login($user);
    }
}