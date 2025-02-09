<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Middleware\DebugMiddleware;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\DefaultSchemaManagerFactory;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\ORM\ORMSetup;
use Symfony\Bridge\Doctrine\Middleware\Debug\DebugDataHolder;
use Symfony\Component\Stopwatch\Stopwatch;

class ConnectionFactory
{
    /**
     * @throws Exception
     */
    public static function create(
        ConnectionWrapper $connection,
        string $env,
        DebugDataHolder $debugDataHolder,
        Stopwatch $stopwatch,
    ): Connection {
        $config = self::createConfiguration('dev' === $env);

        if ('dev' === $env) {
            $config->setMiddlewares([
                new DebugMiddleware($debugDataHolder, $stopwatch),
            ]);
        }

        return DriverManager::getConnection($connection->getParams(), $config, new EventManager());
    }

    public static function createConfiguration(bool $isDevMode): Configuration
    {
        $config = ORMSetup::createConfiguration($isDevMode);

        $config->setMetadataDriverImpl(new SimplifiedXmlDriver(self::getPrefixes()));
        $config->setSchemaManagerFactory(new DefaultSchemaManagerFactory());

        return $config;
    }

    public static function getPrefixes(): array
    {
        return DoctrinePrefixesSearcher::inPath(
            __DIR__.'/../../..',
            'App'
        );
    }
}
