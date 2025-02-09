<?php

declare(strict_types=1);

namespace App\Users\Application\Find;

use App\Shared\Domain\Bus\Query\Response;
use App\Users\Domain\Entity\User;

readonly class ResponseFindUser implements Response
{
    public function __construct(
        private mixed $user = null,
    ) {
    }

    public function user(): ?User
    {
        return $this->user;
    }
}
