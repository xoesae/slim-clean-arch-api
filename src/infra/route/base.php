<?php

use Infra\Controller\UserController;
use Slim\App as SlimApp;

return function (SlimApp $app) {
    $app->get('/', [UserController::class, 'index']);
};