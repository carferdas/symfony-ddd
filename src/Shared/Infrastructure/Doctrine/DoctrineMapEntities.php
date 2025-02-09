<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;

class DoctrineMapEntities
{
    public static function handle(ContainerBuilder $container): void
    {
        $finder = Finder::create();
        $finder
            ->files()
            ->in(realpath(__DIR__.'/../../..'))
            ->name('*.orm.xml');

        $namespaces = [];

        foreach ($finder as $file) {
            $directory = $file->getPath();

            $relativePath = str_replace('/', '\\', $file->getRelativePath());

            if (!isset($namespaces[$directory])) {
                $namespaces[$directory] = 'App\\'.explode('\\', $relativePath)[0].'\\Domain\\Entity';
            }
        }

        $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver($namespaces));
    }
}
