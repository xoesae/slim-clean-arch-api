<?php

namespace Infra\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BaseController
{
    public function index(Request $request, Response $response, array $args): Response
    {
        return json_response($response, ['hello' => 'world']);
    }
}