<?php

declare(strict_types=1);

namespace App\Users\Application\Edit;

use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Users\Domain\Entity\UserId;
use App\Users\Domain\Repository\UserRepository;

final readonly class UpdateUserCommandHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function __invoke(UpdateUserCommand $command): void
    {
        $user = $this->userRepository->search(new UserId($command->id()));

        $user->setFirstName($command->firstName());
        $user->setLastName($command->lastName());
        $user->setEmail($command->email());
        $user->setPassword($command->password());
        $user->setIsActive($command->isActive());

        $this->userRepository->update($user);
    }
}
