<?php
declare(strict_types = 1);

namespace DemoApiContext\Infrastructure\Monolog\Processor;

use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Monolog\Processor\AbstractProcessor;

/**
 * Class IntrospectionInfrastructureProcessor
 *
 * @category DemoApiContext
 * @package Infrastructure
 * @subpackage Monolog\Processor
 *
 * @license MIT
 */
class IntrospectionInfrastructureProcessor extends AbstractProcessor
{
    /**
     * Processes the record for the Infrastructure layer.
     *
     * @param array $record
     * @return array
     */
    public function processRecord(array $record): array
    {
        // Fill this method if needed.
        return $record;
    }
}
