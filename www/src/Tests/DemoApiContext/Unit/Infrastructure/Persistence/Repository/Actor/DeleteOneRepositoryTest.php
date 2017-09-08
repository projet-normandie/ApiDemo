<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Infrastructure\Persistence\Repository\Actor;

use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Infrastructure\Persistence\Repository\Actor\Orm\DeleteOneRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * Class DeleteOneRepositoryTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Infrastructure
 * @subpackage Persistence\Repository\Actor
 *
 * @coversDefaultClass DeleteOneRepository
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class DeleteOneRepositoryTest extends TestCase
{
    /** @var DeleteOneRepository $repository */
    protected $repository;

    /** @var stdClass $object */
    protected $object;

    /**
     * @var Phake_IMock $em Mock instance of EntityManager
     * @see EntityManager
     */
    protected $em;

    /**
     * @var Phake_IMock $qb Mock instance of QueryBuilder
     * @see QueryBuilder
     */
    protected $qb;

    /** @var stdClass $query */
    protected $query;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        $this->object = new stdClass();
        $this->object->entityId = 'good';
        $this->em = Phake::mock(EntityManager::class);
        $this->qb = Phake::partialMock(QueryBuilder::class, $this->em);
        Phake::when($this->em)->createQueryBuilder()->thenReturn($this->qb);
        $this->repository = new DeleteOneRepository($this->em, Actor::class);

        // Anonymous class because it is not possible to build a Mock of final class Doctrine\ORM\Query.
        $this->query = new class {
            public $executeCalled = false;

            /**
             * Execute function
             *
             * @return int
             */
            public function execute(): int
            {
                $this->executeCalled = true;
                return 1;
            }
        };
    }

    /**
     * Tests the getter.
     *
     * @covers ::getEntityName()
     */
    public function testGetter(): void
    {
        $expected = Actor::class;
        $result = $this->repository->getEntityName();
        static::assertEquals($expected, $result);
    }

    /**
     * Tests the setter
     *
     * @covers ::setEntityName()
     */
    public function testSetter(): void
    {
        $expected = Actor::class;
        $this->repository->setEntityName($expected);
        $result =$this->repository->getEntityName();
        static::assertEquals($expected, $result);
    }

    /**
     * Tests repository execute
     *
     * @covers ::execute()
     */
    public function testExecute(): void
    {
        Phake::when($this->qb)->getQuery()->thenReturn($this->query);
        $expected = 1;
        $result = $this->repository->execute($this->object);
        Phake::verify($this->em, Phake::times(1))->createQueryBuilder(Phake::anyParameters());
        Phake::verify($this->qb, Phake::times(1))->getQuery(Phake::anyParameters());
        static::assertTrue($this->query->executeCalled);
        static::assertEquals($expected, $result);
    }
}
