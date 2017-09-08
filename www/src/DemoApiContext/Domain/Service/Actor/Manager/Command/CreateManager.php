<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Service\Actor\Manager\Command;

use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Domain\ValueObject\ActorVO;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Exception\DomainException;
use stdClass;

/**
 * Class CreateManager
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Service\Actor\Manager\Command
 *
 * @license MIT
 */
class CreateManager extends CommandManager
{
    /**
     * Processes the action: Create.
     *
     * @param stdClass $object
     * @return Actor
     * @throws DomainException
     */
    public function process(stdClass $object): Actor
    {
        return $this->create($object->actorVO);
    }

    /**
     * Calls the execution of the action Create.
     *
     * @param ActorVO $actorVO
     * @return Actor
     * @throws DomainException
     */
    protected function create(ActorVO $actorVO): Actor
    {
        // Construct the entity thanks to VO.
        $entity = Actor::build($actorVO);

        // Execute the creation.
        $this->execute($entity);

        // Log the creation.
        $this->logger->info(
            'Actor ' . $entity->getId() . ' has been created.',
            ['actor' => $entity]
        );

        return $entity;
    }
}
