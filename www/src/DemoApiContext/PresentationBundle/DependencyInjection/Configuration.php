<?php
declare(strict_types = 1);

namespace DemoApiContext\PresentationBundle\DependencyInjection;

use RuntimeException;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @category DemoApiContext
 * @package PresentationBundle
 * @subpackage DependencyInjection
 *
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class
 * }
 *
 * @license MIT
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     * @throws RuntimeException
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('demoapi_presentation');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
