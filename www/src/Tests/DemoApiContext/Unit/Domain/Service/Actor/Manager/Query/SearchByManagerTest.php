<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Domain\Service\Actor\Manager\Query;

use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Infrastructure\Persistence\FieldsDefinition\Actor as FieldActor;
use DemoApiContext\Infrastructure\Persistence\Repository\Actor\Orm\SearchByRepository;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Specification\SpecificationInterface;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Factory\RepositoryFactoryInterface;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Manager\Query\SearchByManager;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Logger\Generalisation\LoggerInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\CustomType\Criteria;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\CustomType\OrderBy;
use stdClass;

/**
 * Class SearchByManagerTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Domain
 * @subpackage Service\Actor\Manager\Query
 *
 * @coversDefaultClass SearchByManager
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class SearchByManagerTest extends TestCase
{
    /**
     * @var Phake_IMock Mock instance of RepositoryFactoryInterface.
     * @see RepositoryFactoryInterface
     */
    protected $repositoryFactory;

    /**
     * @var SearchByManager
     */
    protected $searchByManager;

    /**
     * @var Phake_IMock Mock instance of LoggerInterface.
     * @see LoggerInterface
     */
    protected $logger;

    /**
     * @var Phake_IMock Mock instance of SearchByRepository.
     * @see SearchByRepository
     */
    protected $searchByRepository;

    /**
     * @var FieldActor
     */
    protected $fieldDefinition;

    /**
     * Initiates the test.
     */
    public function setUp(): void
    {
        $this->initRepositoryFactory();
        $this->fieldDefinition = Phake::mock(FieldActor::class);
        $this->searchByManager = new SearchByManager($this->repositoryFactory, $this->fieldDefinition);
        $this->logger = Phake::mock(LoggerInterface::class);
        $this->searchByManager->setLogger($this->logger);
    }

    /**
     * Tests working process.
     *
     * @covers ::process()
     */
    public function testSearchBy(): void
    {
        Phake::when($this->searchByRepository)
            ->execute(Phake::anyParameters())
            ->thenReturn([Phake::mock(Actor::class), Phake::mock(Actor::class)]);

        $object = new stdClass();
        $object->criteria = Phake::mock(Criteria::class);
        $object->orderBy = Phake::mock(OrderBy::class);
        Phake::when($object->orderBy)->getOrders()->thenReturn([]);

        $spec = Phake::mock(SpecificationInterface::class);
        Phake::when($spec)->manageSpecificationForManager(Phake::anyParameters())->thenReturn($spec);

        Phake::when($object->criteria)->getSpecification()->thenReturn($spec);

        $result = $this->searchByManager->process($object);
        static::assertTrue(\is_array($result));
        foreach ($result as $item) {
            static::assertInstanceOf(Actor::class, $item);
        }
        Phake::verify($this->repositoryFactory, Phake::times(1))
            ->buildRepository(RepositoryFactoryInterface::SEARCH_BY_REPOSITORY);
        Phake::verify($this->searchByRepository, Phake::times(1))->execute(Phake::anyParameters());
    }

    /**
     * Initiates the Repository Factory.
     */
    private function initRepositoryFactory(): void
    {
        $this->repositoryFactory = Phake::mock(RepositoryFactoryInterface::class);
        $this->searchByRepository = Phake::mock(SearchByRepository::class);

        Phake::when($this->repositoryFactory)
            ->buildRepository(RepositoryFactoryInterface::SEARCH_BY_REPOSITORY)
            ->thenReturn($this->searchByRepository);
    }
}
