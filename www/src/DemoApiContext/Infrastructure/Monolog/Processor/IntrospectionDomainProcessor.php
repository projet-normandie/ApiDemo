<?php
declare(strict_types = 1);

namespace DemoApiContext\Infrastructure\Monolog\Processor;

use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Monolog\Processor\AbstractProcessor;

/**
 * Class IntrospectionDomainProcessor
 *
 * @category DemoApiContext
 * @package Infrastructure
 * @subpackage Monolog\Processor
 *
 * @license MIT
 */
class IntrospectionDomainProcessor extends AbstractProcessor
{
    /**
     * Processes the record for the Domain layer.
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
