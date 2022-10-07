<?php
namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\core\Request;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function home()
    {
        $params = [
            'name' => 'Le Vinh Quang'
        ];
        return $this->reder('home', $params);
    }

    public function contact(Request $request)
    {
        $contact = new ContactForm();
        if($request->isPost()) {
            $contact->loadData($request->getBody());
            if($contact->validate() && $contact->send()) {
                Application::$app->session->setFlash('success', 'Thanks for contacting us.');
                Application::$app->response->redirect('/contact');
                exit;
            }
        }
        return $this->reder('contact', [
            'model' => $contact
        ]);
    }
}