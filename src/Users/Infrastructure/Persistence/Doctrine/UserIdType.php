<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Persistence\Doctrine;

use App\Shared\Infrastructure\Persistence\Doctrine\UuidType;
use App\Users\Domain\Entity\UserId;

class UserIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return UserId::class;
    }
}
