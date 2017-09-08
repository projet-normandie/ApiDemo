<?php
declare(strict_types = 1);

namespace DemoApiContext\InfrastructureBundle;

use DemoApiContext\InfrastructureBundle\DependencyInjection\Compiler\ChangeRepositoryFactoryPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class DemoApiContextInfrastructureBundle
 *
 * @category DemoApiContext
 * @package InfrastructureBundle
 *
 * @license MIT
 */
class DemoApiContextInfrastructureBundle extends Bundle
{
    /**
     * Builds the bundle.
     * It is only ever called once when the cache is empty.
     * This method can be overridden to register compilation passes or other extensions which is the case here.
     *
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new ChangeRepositoryFactoryPass());
    }
}
