<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Domain\Service\Actor\Manager\Query;

use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Infrastructure\Persistence\Repository\Actor\Orm\GetAllRepository;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Factory\RepositoryFactoryInterface;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Manager\Query\GetAllManager;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Logger\Generalisation\LoggerInterface;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Persistence\FieldsDefinition\FieldsDefinitionAbstract;
use stdClass;

/**
 * Class GetAllManagerTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Domain
 * @subpackage Service\Actor\Manager\Query
 *
 * @coversDefaultClass GetAllManager
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class GetAllManagerTest extends TestCase
{
    /**
     * @var Phake_IMock Mock instance of RepositoryFactoryInterface.
     * @see RepositoryFactoryInterface
     */
    protected $repositoryFactory;

    /**
     * @var Phake_IMock Mock instance of FieldsDefinitionAbstract.
     * @see FieldsDefinitionAbstract
     */
    protected $fieldsDefinition;

    /**
     * @var GetAllManager
     */
    protected $getAllManager;

    /**
     * @var Phake_IMock Mock instance of LoggerInterface.
     * @see LoggerInterface
     */
    protected $logger;

    /**
     * @var Phake_IMock Mock instance of GetAllRepository.
     * @see GetAllRepository
     */
    protected $getAllRepository;

    /**
     * Initiates the test.
     */
    public function setUp(): void
    {
        $this->initRepositoryFactory();
        $this->initFieldsDefinition();
        $this->getAllManager = new GetAllManager($this->repositoryFactory, $this->fieldsDefinition);
        $this->logger = Phake::mock(LoggerInterface::class);
        $this->getAllManager->setLogger($this->logger);
    }

    /**
     * Tests working process.
     *
     * @covers ::process()
     */
    public function testGetAll(): void
    {
        Phake::when($this->getAllRepository)
            ->execute(Phake::anyParameters())
            ->thenReturn([Phake::mock(Actor::class), Phake::mock(Actor::class)]);

        $result = $this->getAllManager->process(new stdClass());
        static::assertTrue(\is_array($result));
        foreach ($result as $item) {
            static::assertInstanceOf(Actor::class, $item);
        }
        Phake::verify($this->repositoryFactory, Phake::times(1))
            ->buildRepository(RepositoryFactoryInterface::GET_ALL_REPOSITORY);
        Phake::verify($this->getAllRepository, Phake::times(1))->execute(Phake::anyParameters());
    }

    /**
     * Tests getting empty array on GetAllManager process method.
     *
     * @covers ::process()
     */
    public function testGetAllEmptyResult(): void
    {
        Phake::when($this->getAllRepository)
            ->execute(Phake::anyParameters())
            ->thenReturn([]);
        $result = $this->getAllManager->process(new stdClass());
        static::assertTrue(\is_array($result));
        static::assertCount(0, $result);
        Phake::verify($this->repositoryFactory, Phake::times(1))
            ->buildRepository(RepositoryFactoryInterface::GET_ALL_REPOSITORY);
        Phake::verify($this->getAllRepository, Phake::times(1))->execute(Phake::anyParameters());
    }

    /**
     * Initiates the Repository Factory.
     */
    private function initRepositoryFactory(): void
    {
        $this->repositoryFactory = Phake::mock(RepositoryFactoryInterface::class);
        $this->getAllRepository = Phake::mock(GetAllRepository::class);

        Phake::when($this->repositoryFactory)
            ->buildRepository(RepositoryFactoryInterface::GET_ALL_REPOSITORY)
            ->thenReturn($this->getAllRepository);
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
