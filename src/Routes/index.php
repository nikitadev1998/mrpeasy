<?php

namespace WebApp\Routes;


use Exception;
use WebApp\Controllers\HomeController;
use WebApp\Router;

$router = new Router();

$router->get('/counter-increment', HomeController::class, 'actionIncrement');
$router->get('/', HomeController::class, 'actionIndex');
$router->post('/', HomeController::class, 'actionIndex');
$router->get('/not-found', HomeController::class, 'actionNotFound');
$router->get('/index', HomeController::class, 'actionIndex');
$router->get('/login', HomeController::class, 'actionLogin');
$router->post('/login', HomeController::class, 'actionLogin');
$router->get('/logout', HomeController::class, 'actionLogout');

try {
    $router->dispatch();
} catch (Exception $e) {
    header("location: http://{$_SERVER['HTTP_HOST']}/not-found");
}