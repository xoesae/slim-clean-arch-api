<?php

namespace Presentation\Controller;

use Application\Data\DTO\UserDTO;
use Domain\Exception\MustBeUniqueException;
use Domain\Exception\NotFoundException;
use Domain\UseCase\UserUseCase;
use Presentation\Http\JsonRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final readonly class UserController
{
    public function __construct(
        private JsonRenderer $renderer,
        private UserUseCase  $useCase,
    ){}

    public function index(Request $request, Response $response, array $args): Response
    {
        $users = $this->useCase->findAll();

        return $this->renderer->json($response, $users);
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $user = $this->useCase->findById($args['id']);

        return $this->renderer->json($response, $user);
    }

    public function store(Request $request, Response $response, array $args): Response
    {
        // TODO: implement validation
        $data = json_decode($request->getBody(), true);
        $user = $this->useCase->create($data['name'], $data['email']);

        return $this->renderer->json($response, $user);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        // TODO: implement validation
        $data = json_decode($request->getBody(), true);
        $user = $this->useCase->update($args['id'], $data['name'], $data['email']);

        return $this->renderer->json($response, $user);
    }

    /**
     * @throws NotFoundException
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        $result = $this->useCase->delete($args['id']);

        return $this->renderer->json($response, [
            'success' => $result,
        ]);
    }
}