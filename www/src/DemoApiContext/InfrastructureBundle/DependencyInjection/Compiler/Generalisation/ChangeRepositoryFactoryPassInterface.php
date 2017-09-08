<?php
declare(strict_types = 1);

namespace DemoApiContext\InfrastructureBundle\DependencyInjection\Compiler\Generalisation;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Interface ChangeRepositoryFactoryPassInterface
 *
 * @category DemoApiContext
 * @package InfrastructureBundle
 * @subpackage DependencyInjection\Compiler\Generalisation
 *
 * @license MIT
 */
interface ChangeRepositoryFactoryPassInterface extends CompilerPassInterface
{
    /**
     * Sets the entities to change the repository factory.
     *
     * @param array $entities Entities list
     * @return $this
     */
    public function setEntities(array $entities);
}
