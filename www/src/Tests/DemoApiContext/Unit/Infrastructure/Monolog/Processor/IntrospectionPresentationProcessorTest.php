<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Infrastructure\Monolog\Processor;

use DemoApiContext\Infrastructure\Monolog\Processor\IntrospectionPresentationProcessor;
use Phake;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class IntrospectionPresentationProcessorTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Infrastructure
 * @subpackage Monolog\Processor
 *
 * @coversDefaultClass IntrospectionPresentationProcessor
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class IntrospectionPresentationProcessorTest extends TestCase
{
    /**
     * Tests processRecord.
     *
     * @covers ::processRecord()
     */
    public function testProcessRecord(): void
    {
        $token = Phake::mock(TokenStorageInterface::class);
        $processor = new IntrospectionPresentationProcessor($token);
        static::assertInternalType('array', $processor->processRecord([]));
    }
}
