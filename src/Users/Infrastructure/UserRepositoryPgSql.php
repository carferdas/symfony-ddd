<?php

declare(strict_types=1);

namespace App\Users\Infrastructure;

use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Entity\UserId;
use App\Users\Domain\Repository\UserRepository;

class UserRepositoryPgSql extends DoctrineRepository implements UserRepository
{
    public function save(User $user): void
    {
        $this->persist($user);
    }

    public function search(UserId $id): ?User
    {
        return $this->repository(User::class)->find($id);
    }

    public function list(int $limit, ?int $page, ?string $search): array
    {
        return $this->repository(User::class)
            ->findBy([], [], $limit, max(0, ($page - 1) * $limit));
    }

    public function update(User $user): void
    {
        $this->persist($user);

        $this->entityManager()->flush();
    }

    public function delete(UserId $userId): void
    {
        $user = $this->entityManager()->getReference(User::class, $userId);

        $this->entityManager()->remove($user);

        $this->entityManager()->flush();
    }
}
