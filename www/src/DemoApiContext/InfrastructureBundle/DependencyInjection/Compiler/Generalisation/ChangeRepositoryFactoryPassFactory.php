<?php
declare(strict_types = 1);

namespace DemoApiContext\InfrastructureBundle\DependencyInjection\Compiler\Generalisation;

use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Persistence\Generalisation\MultipleDatabaseInterface;

/**
 * Class ChangeRepositoryFactoryPassFactory
 *
 * @category DemoApiContext
 * @package InfrastructureBundle
 * @subpackage DependencyInjection\Compiler\Generalisation
 *
 * @license MIT
 */
class ChangeRepositoryFactoryPassFactory
{
    public static $mapping = [
        MultipleDatabaseInterface::ORM_DATABASE_TYPE => ChangeOrmRepositoryFactoryPass::class
    ];

    /**
     * Create the class that will change the factory class regarding the DB type.
     *
     * @param string $type Database used
     * @return ChangeRepositoryFactoryPassInterface
     */
    public static function create(string $type): ChangeRepositoryFactoryPassInterface
    {
        // No need to check the existence of the key $type given as it is required to be one of the
        // ChangeRepositoryFactoryPassFactory::$mapping keys, as expected and checked in
        // DemoApiContext\InfrastructureBundle\DependencyInjection\Configuration::getConfigTreeBuilder().
        return new static::$mapping[$type]();
    }
}
