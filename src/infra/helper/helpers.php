<?php

use Psr\Http\Message\ResponseInterface;

if (! function_exists('json_response')) {
    function json_response(ResponseInterface $response, array $data): ResponseInterface
    {
        $response->getBody()->write(json_encode($data));

        return $response;
    }
}