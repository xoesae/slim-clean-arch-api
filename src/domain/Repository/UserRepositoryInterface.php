<?php

namespace Domain\Repository;

use Domain\Entity\User;
use Domain\Exception\NotFoundException;

interface UserRepositoryInterface
{
    /**
     * @return array<User>
     */
    public function findAll(): array;

    /**
     * @throws NotFoundException
     */
    public function findById(int $id): User;

    public function emailExists(string $email): bool;

    public function create(User $user): void;
}