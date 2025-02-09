<?php

declare(strict_types=1);

namespace App\Users\Application\List;

use App\Shared\Domain\Bus\Query\QueryHandler;
use App\Users\Domain\Repository\UserRepository;

readonly class ListUsersQueryHandler implements QueryHandler
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function __invoke(ListUsersQuery $query): ResponseListUsers
    {
        return new ResponseListUsers(
            $this->userRepository->list($query->limit(), $query->page(), $query->search())
        );
    }
}
