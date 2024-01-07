<?php

use Presentation\Http\JsonRenderer;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\App as SlimApp;

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
        // TODO: implement logger
        $logger?->error($exception->getMessage());

        $payload = [
            'error' => $exception->getMessage(),
            'code' => $exception->getCode(),
        ];

        if ($displayErrorDetails) {
            $payload['trace'] = $exception->getTrace();
        }

        $renderer = new JsonRenderer();
        $response = $app->getResponseFactory()->createResponse();
        $response = $renderer->json($response, $payload);

        return $response->withStatus($exception->getCode());
    };

    // TODO: get APP_DEBUG env
    $displayErrorDetails = true;
    $errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, true, true);
    $errorMiddleware->setDefaultErrorHandler($errorHandler);
};