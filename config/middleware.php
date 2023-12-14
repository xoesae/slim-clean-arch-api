<?php

use Infra\Http\Middleware\ResponseJsonMiddleware;
use Slim\App as SlimApp;

return function (SlimApp $app) {
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();
    $app->addErrorMiddleware(true, true, true);
    $app->add(ResponseJsonMiddleware::class);
};