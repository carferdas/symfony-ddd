<?php

declare(strict_types=1);

namespace Users\Application;

use App\Shared\Domain\Bus\Event\EventBus;
use App\Users\Application\Create\CreateUser;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Entity\UserId;
use App\Users\Domain\Repository\UserRepository;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class CreateUserTest extends TestCase
{
    private UserRepository $repository;
    private EventBus $eventBus;
    private CreateUser $createUser;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->repository = $this->createMock(UserRepository::class);
        $this->eventBus = $this->createMock(EventBus::class);
        $this->createUser = new CreateUser($this->repository, $this->eventBus);
    }

    public function test_a_user_can_be_created()
    {
        $userId = UserId::random()->value();
        $firstName = 'John';
        $lastName = 'Doe';
        $email = 'john@doe.com';
        $password = 'password';
        $isActive = true;

        $this->eventBus->expects($this->once())->method('publish');

        $this->repository->expects($this->once())
            ->method('save')
            ->with($this->callback(function (User $user) use ($userId, $firstName, $lastName, $email, $password, $isActive) {
                return $user->getId() === $userId
                    && $user->getFirstName() === $firstName
                    && $user->getLastName() === $lastName
                    && $user->getEmail() === $email
                    && $user->getPassword() === $password
                    && $user->isActive() === $isActive;
            }));

        $this->createUser->handle(new UserId($userId), $firstName, $lastName, $email, $password);
    }

    public function test_a_user_can_be_created_with_an_inactive_status(): void
    {
        $userId = UserId::random()->value();
        $firstName = 'Jane';
        $lastName = 'Doe';
        $email = 'jane.doe@example.com';
        $password = 'password';
        $isActive = false;

        $this->eventBus->expects($this->once())
            ->method('publish');

        $this->repository->expects($this->once())
            ->method('save')
            ->with($this->callback(function (User $user) use ($isActive) {
                return $user->isActive() === $isActive;
            }));

        $this->createUser->handle(new UserId($userId), $firstName, $lastName, $email, $password, false);
    }
}