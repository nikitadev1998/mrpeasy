<?php

namespace WebApp\Controllers;

use WebApp\Controller;
use WebApp\Models\LoginForm;
use WebApp\Models\User;

/**
 * Class HomeController
 * @package WebApp\Controllers
 */
class HomeController extends Controller
{
    public function actionIndex()
    {
        if (isset($_SESSION['username'])) {
            $this->render('index');
        } else {
            $this->redirect('login');
        }
    }

    public function actionLogin()
    {
        $loginForm = new LoginForm();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->render('login');
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($loginForm->load($_POST) && $loginForm->validate()) {
                if ($loginForm->signIn()) {
                    $this->redirect('index');
                } else {
                    $this->render('login', $loginForm->getViewAttributes());
                }
            }
        }
    }

    public function actionLogout()
    {
        session_destroy();
        $this->redirect('login');
    }

    public function actionIncrement(): bool
    {
        $user = User::findOne(['username' => $_SESSION['username']]);
        $user->counter++;
        if ($user->update(['counter'])) {
            $_SESSION['counter'] = $user->counter;
            return true;
        } else {
            return false;
        }
    }

    public function actionNotFound()
    {
        $this->render('error');
    }
}