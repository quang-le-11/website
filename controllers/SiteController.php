<?php
namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\core\Request;

class SiteController extends Controller
{
    public function home()
    {
        $params = [
            'name' => 'Le Vinh Quang'
        ];
        return $this->reder('home', $params);
    }

    public function contact()
    {
        return $this->reder('contact');
    }

    public function handleContact(Request $request)
    {

        $body = $request->getBody();
        return 'Submit data';
    }
}