<?php

declare(strict_types=1);

namespace App\Users\Application\List;

use App\Shared\Domain\Bus\Query\Response;

class ResponseListUsers implements Response
{
    public function __construct(
        public array $users,
    ) {
    }
}
