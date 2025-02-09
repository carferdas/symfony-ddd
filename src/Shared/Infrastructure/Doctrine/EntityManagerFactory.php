<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine;

use App\Shared\Infrastructure\Doctrine\Dbal\DbalCustomTypesRegistrar;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

final class EntityManagerFactory
{
    public static function create(
        Connection $connection,
        string $env,
    ): EntityManager {
        DbalCustomTypesRegistrar::register(
            DbalTypesSearcher::inPath(__DIR__.'/../../..')
        );

        $eventManager = new EventManager();
        $config = ORMSetup::createConfiguration('dev' === $env);

        $config->setMiddlewares($connection->getConfiguration()->getMiddlewares());
        $config->setMetadataDriverImpl($connection->getConfiguration()->getMetadataDriverImpl());
        $config->setSchemaManagerFactory($connection->getConfiguration()->getSchemaManagerFactory());

        return new EntityManager($connection, $config, $eventManager);
    }
}
