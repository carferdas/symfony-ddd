<?php

namespace App\Shared\Infrastructure\Symfony;

use App\Shared\Infrastructure\Doctrine\DoctrineMapEntities;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $container): void
    {
        $this->registerMapping($container);
    }

    private function registerMapping(ContainerBuilder $container): void
    {
        DoctrineMapEntities::handle($container);
    }
}
