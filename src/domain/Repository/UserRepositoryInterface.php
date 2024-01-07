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

    public function emailExists(string $email, array $ignoreIds = []): bool;

    public function create(User $user): void;

    public function update(User $user): void;

    public function delete(User $user): bool;
}