<?php
declare(strict_types = 1);

namespace DemoApiContext\PresentationBundle;

use DemoApiContext\PresentationBundle\DependencyInjection\Compiler\ResettingListenersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class DemoApiContextPresentationBundle
 *
 * @category DemoApiContext
 * @package PresentationBundle
 *
 * @license MIT
 */
class DemoApiContextPresentationBundle extends Bundle
{
    /**
     * Builds the bundle with the container and add the compiler pass to the container.
     * Adds the compiler pass "RegisterListenersPass".
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new ResettingListenersPass());
    }
}
