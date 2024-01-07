<?php

use Presentation\Controller\BaseController;
use Slim\App as SlimApp;

return function (SlimApp $app) {
    $app->get('/', [BaseController::class, 'index']);
};