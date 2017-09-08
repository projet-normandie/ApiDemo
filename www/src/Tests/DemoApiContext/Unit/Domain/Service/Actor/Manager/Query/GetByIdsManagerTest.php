<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Domain\Service\Actor\Manager\Query;

use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Domain\Service\Actor\Factory\Orm\RepositoryFactory;
use DemoApiContext\Infrastructure\Persistence\Repository\Actor\Orm\GetByIdsRepository;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Factory\RepositoryFactoryInterface;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Manager\Query\GetByIdsManager;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Logger\Generalisation\LoggerInterface;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Persistence\FieldsDefinition\FieldsDefinitionAbstract;
use stdClass;

/**
 * Class GetByIdsManagerTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Domain
 * @subpackage Service\Actor\Manager\Query
 *
 * @coversDefaultClass GetByIdsManager
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class GetByIdsManagerTest extends TestCase
{
    /**
     * @var Phake_IMock Mock instance of RepositoryFactory.
     * @see RepositoryFactory
     */
    protected $repositoryFactory;

    /**
     * @var Phake_IMock Mock instance of FieldsDefinitionAbstract.
     * @see FieldsDefinitionAbstract
     */
    protected $fieldsDefinition;

    /**
     * @var GetByIdsManager
     */
    protected $manager;

    /**
     * @var Phake_IMock Mock instance of LoggerInterface.
     * @see LoggerInterface
     */
    protected $logger;

    /**
     * @var Phake_IMock Mock instance of GetByIdsRepository.
     * @see GetByIdsRepository
     */
    protected $getByIdsRepository;

    /**
     * @var Phake_IMock Mock instance of Actor.
     * @see Actor
     */
    protected $actor;

    /**
     * Initiates the test.
     */
    public function setUp(): void
    {
        $this->actor = Phake::mock(Actor::class);
        $this->initRepositoryFactory();
        $this->initFieldsDefinition();
        $this->manager = new GetByIdsManager($this->repositoryFactory, $this->fieldsDefinition);
        $this->logger = Phake::mock(LoggerInterface::class);
        $this->manager->setLogger($this->logger);
    }

    /**
     * Tests working process.
     *
     * @covers ::process()
     */
    public function testGetByIds(): void
    {
        $id = ['some ID', 'other ID'];
        Phake::when($this->getByIdsRepository)
            ->execute(Phake::anyParameters())
            ->thenReturn([$this->actor, Phake::mock(Actor::class)]);

        $object = new stdClass();
        $object->entityIds = $id;
        $result = $this->manager->process($object);
        static::assertTrue(\is_array($result));
        foreach ($result as $item) {
            static::assertInstanceOf(Actor::class, $item);
        }
        Phake::verify($this->repositoryFactory, Phake::times(1))
            ->buildRepository(RepositoryFactoryInterface::GET_BY_IDS_REPOSITORY);
        Phake::verify($this->getByIdsRepository, Phake::times(1))->execute(Phake::anyParameters());
    }

    /**
     * Tests failing process.
     *
     * @expectedException \ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Exception\NotFoundException
     */
    public function testGetByIdsException(): void
    {
        $id = ['some ID', 'other ID'];
        Phake::when($this->getByIdsRepository)->execute(Phake::anyParameters())->thenReturn([]);

        $object = new stdClass();
        $object->entityIds = $id;
        $this->manager->process($object);
    }

    /**
     * Initiates the Repository Factory.
     */
    private function initRepositoryFactory(): void
    {
        $this->repositoryFactory = Phake::mock(RepositoryFactoryInterface::class);
        $this->getByIdsRepository = Phake::mock(GetByIdsRepository::class);

        Phake::when($this->repositoryFactory)
            ->buildRepository(RepositoryFactoryInterface::GET_BY_IDS_REPOSITORY)
            ->thenReturn($this->getByIdsRepository);
    }

    /**
     * Initiates the Fields Definition.
     */
    private function initFieldsDefinition(): void
    {
        $this->fieldsDefinition = Phake::mock(FieldsDefinitionAbstract::class);

        Phake::when($this->fieldsDefinition)
            ->getField(Phake::anyParameters())
            ->thenReturn('lastName');
    }
}
