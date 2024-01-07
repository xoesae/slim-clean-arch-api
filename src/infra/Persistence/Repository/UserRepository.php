<?php

namespace Infra\Persistence\Repository;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Query\Parameter;
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

    public function emailExists(string $email, array $ignoreIds = []): bool
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $where = [
            $queryBuilder->expr()->eq('users.email', ':email'),
        ];
        $params = new ArrayCollection([new Parameter('email', $email)]);

        if (! empty($ignoreIds)) {
            $where[] = $queryBuilder->expr()->notIn('users.id', ':ignore');
            $params->add(new Parameter('ignore', $ignoreIds));
        }

        $queryBuilder
            ->select('users.email')
            ->from(User::class, 'users')
            ->where(
                $queryBuilder->expr()->andX(...$where)
            )
            ->setParameters($params);

        try {
            $result = $queryBuilder
                ->getQuery()
                ->getSingleResult();

            return (bool) $result;
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

    /**
     * @throws OptimisticLockException|ORMException
     */
    public function update(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function delete(User $user): bool
    {
        try {
            $this->entityManager->remove($user);
            $this->entityManager->flush();

            return true;
        } catch (ORMException $e) {
            return false;
        }

    }
}