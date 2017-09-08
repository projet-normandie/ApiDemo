<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Service\Actor\Manager\Command;

use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Domain\ValueObject\ActorVO;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Exception\{DomainException, NotFoundException};
use stdClass;

/**
 * Class UpdateManager
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Service\Actor\Manager\Command
 *
 * @license MIT
 */
class UpdateManager extends CommandManager
{
    /**
     * Processes the action: Update.
     *
     * @param stdClass $object
     * @return Actor
     * @throws DomainException
     * @throws NotFoundException
     */
    public function process(stdClass $object): Actor
    {
        return $this->update($object->entityId, $object->actorVO);
    }

    /**
     * Calls the execution of the action Update.
     *
     * @param string $id
     * @param ActorVO $actorVO
     * @return Actor
     * @throws DomainException
     * @throws NotFoundException
     */
    protected function update(string $id, ActorVO $actorVO): Actor
    {
        // Retrieve the entity thanks to VO and Id.
        $entity = $this->prepareEntity($id, $actorVO);

        // Execute the update.
        $this->execute($entity);

        // Log the update.
        $this->logger->info('Actor ' . $entity->getId() . ' has been updated.', ['actor' => $entity]);

        return $entity;
    }
}
