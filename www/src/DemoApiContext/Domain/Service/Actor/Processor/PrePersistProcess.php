<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Service\Actor\Processor;

use DemoApiContext\Domain\Entity\Actor;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Logger\Generalisation\TraitLogger;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Processor\ProcessInterface;

/**
 * Class PrePersistProcess
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Service\Actor\Processor
 *
 * @license MIT
 */
class PrePersistProcess implements ProcessInterface
{
    use TraitLogger;

    /**
     * This method is called before any persistence action.
     *
     * @param mixed $entity The entity that will be persisted.
     */
    public function update($entity): void
    {
        // Example of use of PrePersist update.
        /** @var Actor $entity */
        $this->logger->info('Pre persist actor with id: ' . $entity->getId() . \PHP_EOL);
    }
}
