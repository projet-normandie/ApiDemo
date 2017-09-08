<?php
declare(strict_types = 1);

namespace DemoApiContext\Infrastructure\Monolog\Processor;

use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Monolog\Processor\AbstractProcessor;

/**
 * Class IntrospectionPresentationProcessor
 *
 * @category DemoApiContext
 * @package Infrastructure
 * @subpackage Monolog\Processor
 *
 * @license MIT
 */
class IntrospectionPresentationProcessor extends AbstractProcessor
{
    /**
     * Processes the record for the Presentation layer.
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
