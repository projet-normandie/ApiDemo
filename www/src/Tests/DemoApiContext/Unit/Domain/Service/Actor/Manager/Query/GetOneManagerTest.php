<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Domain\Service\Actor\Manager\Query;

use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Domain\Service\Actor\Factory\Orm\RepositoryFactory;
use DemoApiContext\Infrastructure\Persistence\Repository\Actor\Orm\GetOneRepository;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Factory\RepositoryFactoryInterface;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Manager\Query\GetOneManager;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Logger\Generalisation\LoggerInterface;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Persistence\FieldsDefinition\FieldsDefinitionAbstract;
use stdClass;

/**
 * Class GetOneManagerTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Domain
 * @subpackage Service\Actor\Manager\Query
 *
 * @coversDefaultClass GetOneManager
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class GetOneManagerTest extends TestCase
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
     * @var GetOneManager
     */
    protected $manager;

    /**
     * @var Phake_IMock Mock instance of LoggerInterface.
     * @see LoggerInterface
     */
    protected $logger;

    /**
     * @var Phake_IMock Mock instance of GetOneRepository.
     * @see GetOneRepository
     */
    protected $getOneRepository;

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
        $this->manager = new GetOneManager($this->repositoryFactory, $this->fieldsDefinition);
        $this->logger = Phake::mock(LoggerInterface::class);
        $this->manager->setLogger($this->logger);
    }

    /**
     * Tests working process.
     *
     * @covers ::process()
     */
    public function testGetOne(): void
    {
        $id = 'some ID';
        Phake::when($this->getOneRepository)
            ->execute(Phake::anyParameters())
            ->thenReturn($this->actor);

        $object = new stdClass();
        $object->entityId = $id;
        $result = $this->manager->process($object);
        static::assertInstanceOf(Actor::class, $result);
        Phake::verify($this->repositoryFactory, Phake::times(1))
            ->buildRepository(RepositoryFactoryInterface::GET_ONE_REPOSITORY);
        Phake::verify($this->getOneRepository, Phake::times(1))->execute(Phake::anyParameters());
    }

    /**
     * Tests failing process.
     *
     * @expectedException \ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Exception\NotFoundException
     */
    public function testGetOneException(): void
    {
        $id = 'some ID';
        Phake::when($this->getOneRepository)
            ->execute(Phake::anyParameters())
            ->thenReturn(null);
        $object = new stdClass();
        $object->entityId = $id;
        $this->manager->process($object);
    }

    /**
     * Initiates the Repository Factory.
     */
    private function initRepositoryFactory(): void
    {
        $this->repositoryFactory = Phake::mock(RepositoryFactoryInterface::class);
        $this->getOneRepository = Phake::mock(GetOneRepository::class);

        Phake::when($this->repositoryFactory)
            ->buildRepository(RepositoryFactoryInterface::GET_ONE_REPOSITORY)
            ->thenReturn($this->getOneRepository);
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
