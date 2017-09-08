<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Infrastructure\Persistence\Repository\Actor;

use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Infrastructure\Persistence\Repository\Actor\Orm\GetByIdsRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * Class GetByIdsRepositoryTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Infrastructure
 * @subpackage Persistence\Repository\Actor
 *
 * @coversDefaultClass GetByIdsRepository
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class GetByIdsRepositoryTest extends TestCase
{
    /** @var GetByIdsRepository $repository */
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
        $this->object->entityIds = ['good', 'johnny'];
        $this->em = Phake::mock(EntityManager::class);
        $this->qb = Phake::partialMock(QueryBuilder::class, $this->em);
        Phake::when($this->em)->createQueryBuilder()->thenReturn($this->qb);
        $this->repository = new GetByIdsRepository($this->em, Actor::class);

        $this->query = Phake::mock(AbstractQuery::class);
        Phake::when($this->query)->setHint(Phake::anyParameters())->thenReturn($this->query);
        Phake::when($this->query)->getSingleScalarResult()->thenReturn(0);
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
        $result = $this->repository->getEntityName();
        static::assertEquals($expected, $result);
    }

    /**
     * Tests repository execute
     *
     * @covers ::execute()
     */
    public function testExecuteWithoutData(): void
    {
        Phake::when($this->query)->getResult()->thenReturn([]);
        Phake::when($this->qb)->getQuery()->thenReturn($this->query);
        $result = $this->repository->execute($this->object);
        Phake::verify($this->em, Phake::times(1))->createQueryBuilder(Phake::anyParameters());
        Phake::verify($this->qb, Phake::times(1))->getQuery(Phake::anyParameters());
        static::assertSame([], $result);
    }

    /**
     * Tests repository execute
     *
     * @covers ::execute()
     */
    public function testExecuteWithData(): void
    {
        Phake::when($this->query)->getResult()->thenReturn([
            Phake::mock(Actor::class),
            Phake::mock(Actor::class)
        ]);
        Phake::when($this->qb)->getQuery()->thenReturn($this->query);
        $result = $this->repository->execute($this->object);
        Phake::verify($this->em, Phake::times(1))->createQueryBuilder(Phake::anyParameters());
        Phake::verify($this->qb, Phake::times(1))->getQuery(Phake::anyParameters());
        static::assertInstanceOf(Actor::class, $result[0]);
        static::assertInstanceOf(Actor::class, $result[1]);
    }
}
