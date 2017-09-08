<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Service\Actor\Factory\CouchDB;

// List of all repositories that are buildable from this factory.
use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Infrastructure\Persistence\Repository\Actor\CouchDB;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Factory\{AbstractRepositoryFactory, RepositoryFactoryInterface};
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Exception\DomainException;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Persistence\Repository\RepositoryInterface;

/**
 * Class RepositoryFactory
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Service\Actor\Factory\CouchDB
 *
 * @license MIT
 */
class RepositoryFactory extends AbstractRepositoryFactory
{
    /**
     * @var string[] List of Repository names the factory is able to load.
     */
    protected const FACTORY_LIST = [
        RepositoryFactoryInterface::GET_ONE_REPOSITORY => CouchDB\GetOneRepository::class,
        RepositoryFactoryInterface::GET_BY_IDS_REPOSITORY => CouchDB\GetByIdsRepository::class,
        RepositoryFactoryInterface::GET_ALL_REPOSITORY => CouchDB\GetAllRepository::class,
        RepositoryFactoryInterface::SEARCH_BY_REPOSITORY => CouchDB\SearchByRepository::class,
        RepositoryFactoryInterface::DELETE_ONE_REPOSITORY => CouchDB\DeleteOneRepository::class,
        RepositoryFactoryInterface::DELETE_MANY_REPOSITORY => CouchDB\DeleteManyRepository::class,
        RepositoryFactoryInterface::SAVE_REPOSITORY => CouchDB\SaveRepository::class,
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
        return new $repositoryName($this->entityManager, Actor::class);
    }
}
