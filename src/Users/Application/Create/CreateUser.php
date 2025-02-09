<?php

declare(strict_types=1);

namespace App\Users\Application\Create;

use App\Shared\Domain\Bus\Event\EventBus;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Entity\UserId;
use App\Users\Domain\Repository\UserRepository;

readonly class CreateUser
{
    public function __construct(
        private UserRepository $repository,
        private EventBus $eventBus,
    ) {
    }

    public function handle(
        UserId $userId,
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        ?bool $isActive = true,
    ): void {
        $user = new User(
            $userId,
            $firstName,
            $lastName,
            $email,
            $password,
            $isActive,
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
        );

        $this->eventBus->publish(...$user->pullDomainEvents());

        $this->repository->save($user);
    }
}
