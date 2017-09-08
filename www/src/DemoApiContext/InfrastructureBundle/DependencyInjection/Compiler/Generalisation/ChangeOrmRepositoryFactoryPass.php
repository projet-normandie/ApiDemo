<?php
declare(strict_types = 1);

namespace DemoApiContext\InfrastructureBundle\DependencyInjection\Compiler\Generalisation;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ChangeOrmRepositoryFactoryPass
 *
 * @category DemoApiContext
 * @package InfrastructureBundle
 * @subpackage DependencyInjection\Compiler\Generalisation
 *
 * @license MIT
 */
class ChangeOrmRepositoryFactoryPass implements ChangeRepositoryFactoryPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function setEntities(array $entities)
    {
        // Nothing to do here as this is the default behavior.
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        // Nothing to do here as this is the default behavior.
    }
}
