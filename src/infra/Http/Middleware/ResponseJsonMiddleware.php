<?php

namespace Infra\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ResponseJsonMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next): Response
    {
        return $response->withHeader('Content-Type', 'application/json');
    }
}