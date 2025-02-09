<?php

declare(strict_types=1);

namespace App\Users\Application\Find;

use App\Shared\Domain\Bus\Query\Query;

final readonly class FindUserQuery implements Query
{
    public function __construct(
        private string $id,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }
}
