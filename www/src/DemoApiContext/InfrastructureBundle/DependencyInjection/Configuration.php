<?php
declare(strict_types = 1);

namespace DemoApiContext\InfrastructureBundle\DependencyInjection;

use DemoApiContext\InfrastructureBundle\DependencyInjection\Compiler\Generalisation\ChangeRepositoryFactoryPassFactory;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @category DemoApiContext
 * @package InfrastructureBundle
 * @subpackage DependencyInjection
 *
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see
 * {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 *
 * @license MIT
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('demoapi_infrastructure');

        /** @noinspection NullPointerExceptionInspection */
        $rootNode
            ->children()
                ->scalarNode('database_type')
                    ->isRequired()
                    ->validate()
                    ->ifNotInArray(\array_keys(ChangeRepositoryFactoryPassFactory::$mapping))
                        ->thenInvalid('Invalid database_type "%s"')
                    ->end()
                    ->cannotBeEmpty()
                ->end()
            ->end();
        return $treeBuilder;
    }
}
