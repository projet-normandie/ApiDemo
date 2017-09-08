<?php
declare(strict_types = 1);

namespace DemoApiContext\PresentationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\{InvalidArgumentException, ServiceNotFoundException};

/**
 * Class ResettingListenersPass
 *
 * @category DemoApiContext
 * @package PresentationBundle
 * @subpackage DependencyInjection\Compiler
 *
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 *
 * @license MIT
 */
class ResettingListenersPass implements CompilerPassInterface
{
    /**
     * @var ContainerBuilder The container where Definitions are.
     */
    protected $container;

    /**
     * @var Definition The event_dispatcher Definition.
     */
    protected $definition;

    /**
     * {@inheritdoc}
     * @throws InvalidArgumentException
     * @throws ServiceNotFoundException
     */
    public function process(ContainerBuilder $container): void
    {
        $this->container = $container;
        $this->definition = $container->findDefinition('event_dispatcher');
        $tags = \array_keys($container->findTaggedServiceIds('project.event_subscriber'));

        \array_map([$this, 'addToDefinition'], $tags);
    }

    /**
     * Adds a method to call in the event_dispatcher Definition using the service identifier name.
     *
     * @param string $serviceId
     * @throws InvalidArgumentException
     * @throws ServiceNotFoundException
     */
    private function addToDefinition(string $serviceId): void
    {
        $this->definition->addMethodCall('addSubscriber', [$this->container->getDefinition($serviceId)]);
    }
}
