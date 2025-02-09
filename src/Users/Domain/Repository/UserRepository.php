<?php

declare(strict_types=1);

namespace App\Users\Domain\Repository;

use App\Users\Domain\Entity\User;
use App\Users\Domain\Entity\UserId;

interface UserRepository
{
    public function save(User $user): void;

    public function search(UserId $id): ?User;

    public function list(int $limit, ?int $page, ?string $search): array;

    public function update(User $user): void;

    public function delete(UserId $userId): void;
}
