<?php

use Presentation\Controller\UserController;
use Slim\App as SlimApp;

return function (SlimApp $app) {
    $app->get('/users', [UserController::class, 'index']);
    $app->get('/user/{id}', [UserController::class, 'show']);
    $app->post('/user', [UserController::class, 'store']);
};