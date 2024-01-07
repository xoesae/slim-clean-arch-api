<?php

namespace Infra\Persistence\Repository;

use DateTimeImmutable;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Domain\Entity\User;
use Domain\Exception\NotFoundException;
use Domain\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManager;

readonly class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private EntityManager $entityManager,
    ) {}

    /**
     * @return array<User>
     */
    public function findAll(): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('users')
            ->from(User::class, 'users');

        return $queryBuilder
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @throws NotFoundException
     */
    public function findById(int $id): User
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('users')
            ->from(User::class, 'users')
            ->where($queryBuilder->expr()->eq('users.id', ':id'))
            ->setParameter('id', $id);

        $query = $queryBuilder->getQuery();

        try {
            return $query->getSingleResult();
        } catch (NoResultException|NonUniqueResultException) {
            throw new NotFoundException("User not found.");
        }
    }

    public function emailExists(string $email): bool
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('users.email')
            ->from(User::class, 'users')
            ->where($queryBuilder->expr()->eq('users.email', ':email'))
            ->setParameter('email', $email);

        $query = $queryBuilder->getQuery();

        try {
            return (bool) $query->getSingleResult();
        } catch (NoResultException|NonUniqueResultException) {
            return false;
        }
    }

    /**
     * @throws OptimisticLockException|ORMException
     */
    public function create(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}