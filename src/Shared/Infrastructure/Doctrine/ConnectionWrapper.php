<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine;

use App\Shared\Infrastructure\Doctrine\Dbal\DbalCustomTypesRegistrar;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;

class ConnectionWrapper extends Connection
{
    public function __construct(
        array $params,
        Driver $driver,
    ) {
        $this->addCustomTypes();

        parent::__construct(
            $params,
            $driver,
            ConnectionFactory::createConfiguration(false),
            new EventManager()
        );
    }

    private function addCustomTypes(): void
    {
        DbalCustomTypesRegistrar::register(
            DbalTypesSearcher::inPath(__DIR__.'/../../..')
        );
    }
}
