<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Query;

use App\Shared\Domain\Bus\Query\Query;

final class QueryNotRegisteredError extends \RuntimeException
{
    public function __construct(Query $query)
    {
        $queryClass = $query::class;

        parent::__construct("The query <$queryClass> has no associated query handler");
    }
}
