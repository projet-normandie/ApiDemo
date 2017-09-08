<?php
declare(strict_types = 1);

namespace DemoApiContext\InfrastructureBundle\DependencyInjection\Compiler;

use DemoApiContext\InfrastructureBundle\DependencyInjection\Compiler\Generalisation\ChangeRepositoryFactoryPassFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

/**
 * Class ChangeRepositoryFactoryPass
 *
 * @category DemoApiContext
 * @package InfrastructureBundle
 * @subpackage DependencyInjection\Compiler
 *
 * @license MIT
 */
class ChangeRepositoryFactoryPass implements CompilerPassInterface
{
    /**
     * @var string[] Entities list
     */
    protected const ENTITIES = [
        'actor',
    ];

    /**
     * Processes the edition of the repository factory path depending of the DBMS to load.
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     * @throws InvalidArgumentException
     */
    public function process(ContainerBuilder $container): void
    {
        ChangeRepositoryFactoryPassFactory::create($container->getParameter('database_type'))
            ->setEntities(static::ENTITIES)
            ->process($container);
    }
}
