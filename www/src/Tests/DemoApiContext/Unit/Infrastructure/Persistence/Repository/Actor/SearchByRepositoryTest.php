<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Infrastructure\Persistence\Repository\Actor;

use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Infrastructure\Persistence\Repository\Actor\Orm\SearchByRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Specification\SpecificationInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\CustomType\Criteria;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\CustomType\Limit;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\CustomType\OrderBy;
use stdClass;

/**
 * Class SearchByRepositoryTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Infrastructure
 * @subpackage Persistence\Repository\Actor
 *
 * @coversDefaultClass SearchByRepository
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class SearchByRepositoryTest extends TestCase
{
    /** @var SearchByRepository $repository */
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
     * Initiates the test.
     *
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        $this->object = new stdClass();
        $this->object->criteria = Phake::mock(Criteria::class);
        $this->object->limit = Phake::mock(Limit::class);
        $this->object->orderBy = Phake::mock(OrderBy::class);
        $this->em = Phake::mock(EntityManager::class);
        $this->qb = Phake::partialMock(QueryBuilder::class, $this->em);
        Phake::when($this->em)->createQueryBuilder()->thenReturn($this->qb);
        Phake::when($this->qb)->expr()->thenReturn(Phake::mock(Expr::class));
        $this->repository = new SearchByRepository($this->em, Actor::class);

        $this->query = Phake::mock(AbstractQuery::class);
        Phake::when($this->query)->getResult()->thenReturn([]);
        Phake::when($this->query)->setHint(Phake::anyParameters())->thenReturn($this->query);
        Phake::when($this->query)->getSingleScalarResult()->thenReturn(0);

        $spec = Phake::mock(SpecificationInterface::class);
        Phake::when($spec)->manageSpecificationForRepository(Phake::anyParameters())->thenReturn($spec);
        Phake::when($this->object->criteria)->getSpecification()->thenReturn($spec);
    }

    /**
     * Tests entityName getter.
     *
     * @covers TraitEntityNameRepository::getEntityName()
     */
    public function testGetter(): void
    {
        $expected = Actor::class;
        $result = $this->repository->getEntityName();
        static::assertEquals($expected, $result);
    }

    /**
     * Tests entityName setter.
     *
     * @covers TraitEntityNameRepository::setEntityName()
     */
    public function testSetter(): void
    {
        $expected = Actor::class;
        $this->repository->setEntityName($expected);
        $result = $this->repository->getEntityName();
        static::assertEquals($expected, $result);
    }

    /**
     * Tests repository execute.
     *
     * @covers AbstractSearchByRepository::execute()
     */
    public function testExecute(): void
    {
        Phake::when($this->qb)->getQuery()->thenReturn($this->query);
        $expected = [
            'total_rows' => 0,
            'results' => []
        ];
        $result = $this->repository->execute($this->object);
        Phake::verify($this->em, Phake::times(1))->createQueryBuilder(Phake::anyParameters());
        Phake::verify($this->qb, Phake::times(2))->getQuery(Phake::anyParameters());
        static::assertEquals($expected, $result);
    }
}
