<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Service\Actor\Manager\Command;

use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Domain\ValueObject\ActorVO;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Manager\Command\AbstractCommandManager;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Manager\Query\TraitFetchSingleEntity;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Exception\{DomainException, NotFoundException};
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Manipulation\TypeHinting\TraitStdClass;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Persistence\Generalisation\CouchDB;
use stdClass;

/**
 * Class CommandManager
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Service\Actor\Manager\Command
 *
 * @license MIT
 */
abstract class CommandManager extends AbstractCommandManager
{
    use TraitStdClass;
    use TraitFetchSingleEntity;

    /**
     * Gets the entity the repository will load.
     *
     * @param stdClass $object
     * @return Actor
     * @throws NotFoundException
     * @throws DomainException
     */
    protected function getEntity(stdClass $object): Actor
    {
        return $this->prepareEntity($object->entityId, $object->actorVO);
    }

    /**
     * Prepares the entity by requesting the repository to fetch it.
     *
     * @param string $id
     * @param ActorVO $actor
     * @return Actor
     * @throws NotFoundException
     * @throws DomainException
     */
    protected function prepareEntity(string $id, ActorVO $actor): Actor
    {
        // Set the fetching mode to only return the entity for CouchDB repositories.
        CouchDB\Query::setFetchingModeOnlyEntity();

        /** @var Actor $entity */
        $entity = $this->fetchSingleEntity(static::buildFromArray(['entityId' => $id]));

        // Hydrate with the VO and the FK.
        return $entity->setActor($actor);
    }
}
