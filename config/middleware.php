<?php

use Presentation\Http\JsonRenderer;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\App as SlimApp;

const HTTP_CODES = [100, 101, 200, 201, 202, 203, 204, 205, 206, 300, 301, 302, 303, 304, 305, 400, 401, 402, 403, 404, 405, 406, 407, 408, 409, 410, 411, 412, 413, 414, 415, 500, 501, 502, 503, 504, 505];

return function (SlimApp $app) {
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();

    $errorHandler = function (
        ServerRequestInterface $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails,
        ?LoggerInterface $logger = null
    ) use ($app) {
        $message = $exception->getMessage();
        $code = $exception->getCode();
        $trace = $exception->getTrace();

        if (! in_array($code, HTTP_CODES)) {
            $code = 500;
        }

        // TODO: implement logger
        $logger?->error($message);

        $payload = [
            'error' => $message,
            'code' => $code,
        ];

        if ($displayErrorDetails) {
            $payload['trace'] = $trace;
        }

        $renderer = new JsonRenderer();
        $response = $app->getResponseFactory()->createResponse();
        $response = $renderer->json($response, $payload);

        return $response->withStatus($code);
    };

    // TODO: get APP_DEBUG env
    $displayErrorDetails = true;
    $errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, true, true);
    $errorMiddleware->setDefaultErrorHandler($errorHandler);
};