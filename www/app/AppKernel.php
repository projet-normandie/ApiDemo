<?php

use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Persistence\Generalisation\MultipleDatabaseInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Class AppKernel
 */
class AppKernel extends Kernel
{
    protected $parameters = [];

    /**
     * AppKernel constructor.
     * @param string $environment
     * @param bool $debug
     */
    public function __construct($environment, $debug)
    {
        parent::__construct($environment, $debug);
        $this->setParameters();
    }

    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
        ];
        if ('demoapi' === $this->getEnvironment()) {
            $bundles[] = new DemoApiContext\InfrastructureBundle\DemoApiContextInfrastructureBundle();
            $bundles[] = new DemoApiContext\PresentationBundle\DemoApiContextPresentationBundle();
        }
        if ($this->isDebug()) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
        }

        return $bundles;
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $vendor_directory = $this->parameters['project.dir.vendor.env'];

        $envParameters['composer.vendor.dir'] = '%kernel.root_dir%/../vendor';
        if (!($vendor_directory === false)) {
            $envParameters['composer.vendor.dir'] = $vendor_directory;
        }

        $envParameters['router.resource.suffix'] = '';
        if ($this->isDebug()) {
            $envParameters['router.resource.suffix'] = '_profiler';
        }

        $loader->load(function ($container) use ($envParameters) {
            $container->getParameterBag()->add($envParameters);
//            $container->loadFromExtension('web_profiler', array(
//                'toolbar' => true,
//            ));
//            $container->loadFromExtension('framework', array(
//                'test' => false,
//            ));
        });
        $database_driver = $this->parameters['database.driver.env'];

//        $environment = $this->isDebug() ? 'dev' : $this->getEnvironment();
//        $dbDriverYmlExtension = $database_driver === false ? '_orm.yml' : '_' . $database_driver . '.yml';
//        // result
//        $path_load = __DIR__ . '/config/' . $this->getEnvironment() . '/config_' . $environment . $dbDriverYmlExtension;

        $env = $this->getEnvironment();

        $path_load = __DIR__ . '/config/' . $env . '/config_' . $env . '_orm.yml';
        if (!($database_driver === false)) {
            $path_load = __DIR__ . '/config/' . $env .
                '/config_' . $env . '_' . $database_driver . '.yml';
            if ($this->isDebug()) {
                $path_load = __DIR__ . '/config/' . $env .
                    '/config_dev' . '_' . $database_driver . '.yml';
            }
        }

        $loader->load($path_load);
    }

    /**
     * For example to manual create scope "request" in CLI you may overload initializeContainer kernel method.
     *
     * @see \Symfony\Component\HttpKernel\Kernel::initializeContainer()
     */
    protected function initializeContainer()
    {
        parent::initializeContainer();
        if (PHP_SAPI === 'cli') {
            $this->getContainer()->set('request', new \Symfony\Component\HttpFoundation\Request(), 'container');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        $env_cache_dir = getenv('SYMFONY__PROJECT__DIR__CACHE__ENV');
        if ((null !== $env_cache_dir) && !empty($env_cache_dir)) {
            return $env_cache_dir;
        }

        return parent::getCacheDir();
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir()
    {
        $env_log_dir = getenv('SYMFONY__PROJECT__DIR__LOG__ENV');
        if (isset($env_log_dir)
            && !empty($env_log_dir)
            && ($env_log_dir !== 'app/logs')
        ) {
            return $env_log_dir;
        }

        return parent::getLogDir();
    }

    protected function getDbDriverValue()
    {
        return $this->parameters['database.driver.env'];
    }

    protected function getVendorValue()
    {
        return $this->parameters['project.dir.vendor.env'];
    }

    protected function setParameters()
    {
        $this->parameters = $this->getEnvParameters();
    }
}
