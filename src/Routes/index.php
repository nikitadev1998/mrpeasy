<?php

namespace WebApp\Routes;


use WebApp\Controllers\HomeController;
use WebApp\Router;

$router = new Router();

$router->get('/', HomeController::class, 'actionIndex');
$router->get('/login', HomeController::class, 'actionLogin');
$router->post('/login', HomeController::class, 'actionLogin');

$router->dispatch();