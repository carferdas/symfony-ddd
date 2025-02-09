<?php

declare(strict_types=1);

namespace App\Users\Application\Delete;

use App\Shared\Domain\Bus\Command\Command;

readonly class DeleteUserCommand implements Command
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
