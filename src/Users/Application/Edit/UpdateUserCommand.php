<?php

declare(strict_types=1);

namespace App\Users\Application\Edit;

use App\Shared\Domain\Bus\Command\Command;

readonly class UpdateUserCommand implements Command
{
    public function __construct(
        private string $id,
        private string $firstName,
        private string $lastName,
        private string $email,
        private string $password,
        private bool $isActive,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }
}
