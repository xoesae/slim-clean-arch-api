<?php

namespace Presentation\Controller;

use Domain\UseCase\UserUseCase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BaseController
{
    public function index(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write(json_encode(['hello' => 'world']));

        return $response;
    }
}