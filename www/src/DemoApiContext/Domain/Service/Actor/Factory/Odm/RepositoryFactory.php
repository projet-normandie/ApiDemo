<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Service\Actor\Factory\Odm;

// List of all repositories that are buildable from this factory.
use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Infrastructure\Persistence\Repository\Actor\Odm;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Factory\{AbstractRepositoryFactory, RepositoryFactoryInterface};
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Exception\DomainException;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Persistence\Repository\RepositoryInterface;

/**
 * Class RepositoryFactory
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Service\Actor\Factory\Odm
 *
 * @license MIT
 */
class RepositoryFactory extends AbstractRepositoryFactory
{
    /**
     * @var string[] List of Repository names the factory is able to load.
     */
    protected const FACTORY_LIST = [
        RepositoryFactoryInterface::GET_ONE_REPOSITORY => Odm\GetOneRepository::class,
        RepositoryFactoryInterface::GET_BY_IDS_REPOSITORY => Odm\GetByIdsRepository::class,
        RepositoryFactoryInterface::GET_ALL_REPOSITORY => Odm\GetAllRepository::class,
        RepositoryFactoryInterface::SEARCH_BY_REPOSITORY => Odm\SearchByRepository::class,
        RepositoryFactoryInterface::DELETE_ONE_REPOSITORY => Odm\DeleteOneRepository::class,
        RepositoryFactoryInterface::DELETE_MANY_REPOSITORY => Odm\DeleteManyRepository::class,
        RepositoryFactoryInterface::SAVE_REPOSITORY => Odm\SaveRepository::class,
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
