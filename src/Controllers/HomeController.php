<?php

namespace WebApp\Controllers;

use WebApp\Controller;
use WebApp\Models\LoginForm;

/**
 * Class HomeController
 * @package WebApp\Controllers
 */
class HomeController extends Controller
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionLogin()
    {
        $loginForm = new LoginForm();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->render('login');
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($loginForm->load($_POST) && $loginForm->validate()) {
                if ($loginForm->signIn()) {
                } else {
                    $this->render('login', $loginForm->getViewAttributes());
                }
            }
        }
    }
}