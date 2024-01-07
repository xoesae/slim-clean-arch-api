<?php

namespace Domain\UseCase;

use DateTimeImmutable;
use DateTimeZone;
use Domain\Entity\User;
use Domain\Exception\MustBeUniqueException;
use Domain\Exception\NotFoundException;
use Domain\Repository\UserRepositoryInterface;
use Exception;

readonly class UserUseCase
{
    public function __construct(
        private UserRepositoryInterface $repository,
    ) {}

    /**
     * @return array<User>
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @throws NotFoundException
     */
    public function findById(int $id): User
    {
        return $this->repository->findById($id);
    }

    /**
     * @throws MustBeUniqueException|Exception
     */
    public function create(string $name, string $email): User
    {
        if ($this->repository->emailExists($email)) {
            throw new MustBeUniqueException("Email must be unique");
        }

        $user = new User($name, $email, new DateTimeImmutable('now', new DateTimeZone('America/Sao_Paulo')));
        $this->repository->create($user);

        return $this->repository->findById($user->id);
    }

    /**
     * @throws NotFoundException|MustBeUniqueException
     */
    public function update(int $id, string $name, string $email): User
    {
        if ($this->repository->emailExists($email, [$id])) {
            throw new MustBeUniqueException("Email must be unique");
        }

        $user = $this->repository->findById($id);
        $user->name = $name;
        $user->email = $email;

        $this->repository->update($user);

        return $user;
    }

    /**
     * @throws NotFoundException
     */
    public function delete(int $id): bool
    {
        $user = $this->repository->findById($id);

        return $this->repository->delete($user);
    }
}