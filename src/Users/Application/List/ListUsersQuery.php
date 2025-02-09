<?php

declare(strict_types=1);

namespace App\Users\Application\List;

use App\Shared\Domain\Bus\Query\Query;

final readonly class ListUsersQuery implements Query
{
    public function __construct(
        private int $limit,
        private ?int $page = null,
        private ?string $search = null,
    ) {
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function page(): ?int
    {
        return $this->page;
    }

    public function search(): ?string
    {
        return $this->search;
    }
}
