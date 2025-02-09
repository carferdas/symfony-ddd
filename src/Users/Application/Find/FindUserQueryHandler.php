<?php

declare(strict_types=1);

namespace App\Users\Application\Find;

use App\Shared\Domain\Bus\Query\QueryHandler;
use App\Users\Domain\Entity\UserId;
use App\Users\Domain\Repository\UserRepository;

readonly class FindUserQueryHandler implements QueryHandler
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function __invoke(FindUserQuery $query): ResponseFindUser
    {
        return new ResponseFindUser(
            $this->userRepository->search(new UserId($query->id()))
        );
    }
}
