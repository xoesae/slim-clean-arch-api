<?php

namespace Presentation\Http;

use Psr\Http\Message\ResponseInterface;

final class JsonRenderer
{
    public function json(ResponseInterface $response, mixed $payload = null): ResponseInterface
    {
        $encodedPayload = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR);
        $response = $response
            ->withHeader('Content-Type', 'application/json');

        $response->getBody()->write((string) $encodedPayload);

        return $response;
    }
}