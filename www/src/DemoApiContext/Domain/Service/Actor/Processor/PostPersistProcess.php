<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Service\Actor\Processor;

use DemoApiContext\Domain\Entity\Actor;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Logger\Generalisation\TraitLogger;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Processor\ProcessInterface;

/**
 * Class PostPersistProcess
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Service\Actor\Processor
 *
 * @license MIT
 */
class PostPersistProcess implements ProcessInterface
{
    use TraitLogger;

    /**
     * This method is called after any persistence action.
     *
     * @param mixed $entity The entity that has just been persisted.
     */
    public function update($entity): void
    {
        // Example of use of PostPersist update.
        /** @var Actor $entity */
        $this->logger->info('Post persist actor with id: ' . $entity->getId() . \PHP_EOL);
    }
}
