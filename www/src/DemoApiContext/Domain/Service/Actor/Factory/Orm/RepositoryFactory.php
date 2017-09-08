<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Service\Actor\Factory\Orm;

// List of all repositories that are buildable from this factory.
use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Infrastructure\Persistence\Repository\Actor\Orm;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Factory\{AbstractRepositoryFactory, RepositoryFactoryInterface};
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Exception\DomainException;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Persistence\Repository\RepositoryInterface;

/**
 * Class RepositoryFactory
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Service\Actor\Factory\Orm
 *
 * @license MIT
 */
class RepositoryFactory extends AbstractRepositoryFactory
{
    /**
     * @var string[] List of Repository names the factory is able to load.
     */
    protected const FACTORY_LIST = [
        RepositoryFactoryInterface::GET_ONE_REPOSITORY => Orm\GetOneRepository::class,
        RepositoryFactoryInterface::GET_BY_IDS_REPOSITORY => Orm\GetByIdsRepository::class,
        RepositoryFactoryInterface::GET_ALL_REPOSITORY => Orm\GetAllRepository::class,
        RepositoryFactoryInterface::SEARCH_BY_REPOSITORY => Orm\SearchByRepository::class,
        RepositoryFactoryInterface::DELETE_ONE_REPOSITORY => Orm\DeleteOneRepository::class,
        RepositoryFactoryInterface::DELETE_MANY_REPOSITORY => Orm\DeleteManyRepository::class,
        RepositoryFactoryInterface::SAVE_REPOSITORY => Orm\SaveRepository::class,
    ];

    /**
     * Builds the repository according to the requested action.
     *
     * @param string $action
     * @return RepositoryInterface
     * @throws DomainException
     */
    public function buildRepository(string $action): RepositoryInterface
    {
        $repositoryName = $this->getRepositoryClass($action);
        $repository = new $repositoryName($this->entityManager, Actor::class);

        $this->addProcessor($repository);

        return $repository;
    }
}
