<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Service\Actor\Manager\Command;

use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Domain\ValueObject\ActorVO;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Exception\{DomainException, NotFoundException};
use stdClass;

/**
 * Class PatchManager
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Service\Actor\Manager\Command
 *
 * @license MIT
 */
class PatchManager extends CommandManager
{
    /**
     * Processes the action: Patch.
     *
     * @param stdClass $object
     * @return Actor
     * @throws DomainException
     * @throws NotFoundException
     */
    public function process(stdClass $object): Actor
    {
        return $this->patch($object->entityId, $object->actorVO);
    }

    /**
     * Calls the execution of the action Patch.
     *
     * @param string $id
     * @param ActorVO $actorVO
     * @return Actor
     * @throws DomainException
     * @throws NotFoundException
     */
    protected function patch(string $id, ActorVO $actorVO): Actor
    {
        // Retrieve the entity thanks to VO and Id.
        $entity = $this->prepareEntity($id, $actorVO);

        // Execute the patch.
        $this->execute($entity);

        // Log the patch.
        $this->logger->info('Actor ' . $entity->getId() . ' has been patched.', ['actor' => $entity]);

        return $entity;
    }
}
