<?php
declare(strict_types = 1);

namespace DemoApiContext\InfrastructureBundle\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\{ContainerBuilder, Loader};
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class DemoApiContextInfrastructureExtension
 *
 * @category DemoApiContext
 * @package InfrastructureBundle
 * @subpackage DependencyInjection
 *
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 *
 * @license MIT
 */
class DemoApiContextInfrastructureExtension extends Extension
{
    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('database_type', $config['database_type']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('autoload.yml');
    }
}
