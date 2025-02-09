<?php

declare(strict_types=1);

namespace App\Users\Application\Delete;

use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Users\Domain\Entity\UserId;
use App\Users\Domain\Repository\UserRepository;

readonly class DeleteUserCommandHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function __invoke(DeleteUserCommand $command): void
    {
        $this->userRepository->delete(new UserId($command->id()));
    }
}
