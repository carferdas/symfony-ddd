<?php

declare(strict_types=1);

namespace App\Users\Application\Create;

use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Shared\Domain\ValueObject\SimpleUuid;
use App\Users\Domain\Entity\UserId;

readonly class CreateUserCommandHandler implements CommandHandler
{
    public function __construct(
        private CreateUser $createUser,
    ) {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $this->createUser->handle(
            new UserId(SimpleUuid::random()->value()),
            $command->firstName(),
            $command->lastName(),
            $command->email(),
            $command->password(),
            $command->isActive(),
        );
    }
}
