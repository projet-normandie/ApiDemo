<?php
declare(strict_types = 1);

namespace DemoApiContext\Infrastructure\Monolog\Handler;

use Monolog\Handler\SocketHandler as MonologSocketHandler;

/**
 * Class SocketHandler
 *
 * @category DemoApiContext
 * @package Infrastructure
 * @subpackage Monolog\Handler
 *
 * @license MIT
 */
class SocketHandler extends MonologSocketHandler
{
    /**
     * Generates the data stream removing the formatted information. Returns a JSON string then.
     *
     * @param array $record
     * @return string
     */
    protected function generateDataStream($record): string
    {
        unset($record['formatted']);

        return \json_encode($record) . \PHP_EOL;
    }
}
