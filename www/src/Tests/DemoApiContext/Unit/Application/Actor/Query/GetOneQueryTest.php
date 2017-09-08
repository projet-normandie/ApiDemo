<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Application\Cqrs\Actor\Query;

use DemoApiContext\Application\Cqrs\Actor\Query\GetOneQuery;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\QueryInterface;

/**
 * Class GetOneQueryTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Application
 * @subpackage Actor\Query
 *
 * @coversDefaultClass GetOneQuery
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class GetOneQueryTest extends TestCase
{
    /**
     * @var GetOneQuery
     */
    protected $query;

    /**
     * @var string
     */
    protected $id;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->id = 'un-super-id';
        $this->query = new GetOneQuery($this->id);
    }

    /**
     * Tests the query interface.
     */
    public function testInterface(): void
    {
        static::assertInstanceOf(QueryInterface::class, $this->query);
    }

    /**
     * Tests the getters.
     *
     * @covers AbstractGetOneQuery::getEntityId()
     */
    public function testGetters(): void
    {
        static::assertEquals($this->id, $this->query->getEntityId());
    }
}
