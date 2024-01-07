<?php

use Presentation\Controller\UserController;
use Slim\App as SlimApp;

return function (SlimApp $app) {
    $app->get('/users', [UserController::class, 'index']);
    $app->get('/user/{id:[0-9]+}', [UserController::class, 'show']);
    $app->post('/user', [UserController::class, 'store']);
    $app->put('/user/{id:[0-9]+}', [UserController::class, 'update']);
    $app->delete('/user/{id:[0-9]+}', [UserController::class, 'delete']);
};