<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Domain\Service\Actor\Manager\Command;

use DateTime;
use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Domain\Service\Actor\Manager\Command\CreateManager;
use DemoApiContext\Domain\ValueObject\ActorVO;
use DemoApiContext\Infrastructure\Persistence\Repository\Actor\Orm\SaveRepository;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Factory\RepositoryFactoryInterface;
use ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\ContactVO;
use ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\ProfileVO;
use ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\SalaryVO;
use ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\SituationVO;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Logger\Generalisation\LoggerInterface;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Persistence\FieldsDefinition\FieldsDefinitionAbstract;
use stdClass;

/**
 * Class CreateManagerTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Domain
 * @subpackage Service\Actor\Manager\Command
 *
 * @coversDefaultClass CreateManager
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class CreateManagerTest extends TestCase
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

    /** @var CreateManager */
    protected $createManager;

    /**
     * @var Phake_IMock Mock instance of LoggerInterface.
     * @see LoggerInterface
     */
    protected $logger;

    /**
     * @var Phake_IMock Mock instance of SaveRepository.
     * @see SaveRepository
     */
    protected $saveRepository;

    /** @var ActorVO */
    protected $actorVO;

    /**
     * Initiates the test.
     */
    public function setUp(): void
    {
        $this->initRepositoryFactory();
        $this->initFieldsDefinition();
        $this->initVOs();
        $this->logger = Phake::mock(LoggerInterface::class);
        $this->createManager = new CreateManager($this->repositoryFactory, $this->fieldsDefinition);
        $this->createManager->setLogger($this->logger);
    }

    /**
     * Tests CreateManager process method.
     *
     * @covers ::process()
     */
    public function testCreate(): void
    {
        $object = new stdClass();
        $object->actorVO = $this->actorVO;
        $result = $this->createManager->process($object);
        static::assertInstanceOf(Actor::class, $result);
        Phake::verify($this->logger, Phake::times(1))->info(Phake::anyParameters());
        Phake::verify($this->repositoryFactory, Phake::times(1))
            ->buildRepository(RepositoryFactoryInterface::SAVE_REPOSITORY);
        Phake::verify($this->saveRepository, Phake::times(1))->execute(Phake::anyParameters());
    }

    /**
     * Initiates the Repository Factory.
     */
    private function initRepositoryFactory(): void
    {
        $this->repositoryFactory = Phake::mock(RepositoryFactoryInterface::class);
        $this->saveRepository = Phake::mock(SaveRepository::class);

        Phake::when($this->repositoryFactory)
            ->buildRepository(RepositoryFactoryInterface::SAVE_REPOSITORY)
            ->thenReturn($this->saveRepository);
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

    /**
     * Initiates the Value Objects.
     */
    private function initVOs(): void
    {
        $oMorphologicActorVO = new stdClass();

        $oMorphologicProfileVO = new stdClass();
        $oMorphologicProfileVO->lastName = 'Good';
        $oMorphologicProfileVO->firstName = 'Johnny';
        $oMorphologicActorVO->profile = ProfileVO::build($oMorphologicProfileVO);

        $oMorphologicSituationVO = new stdClass();
        $oMorphologicSituationVO->sex = 'M';
        $oMorphologicSituationVO->birthday = new DateTime();
        $oMorphologicActorVO->situation = SituationVO::build($oMorphologicSituationVO);

        $oMorphologicContactVO = new stdClass();
        $oMorphologicContactVO->email = 'johnny@good.com';
        $oMorphologicContactVO->phoneNumber1 = '0122334455';
        $oMorphologicContactVO->phoneNumber2 = null;
        $oMorphologicActorVO->contact = ContactVO::build($oMorphologicContactVO);

        $oMorphologicSalaryVO = new stdClass();
        $oMorphologicSalaryVO->value = 1000.0;
        $oMorphologicSalaryVO->currency = 'USD';
        $oMorphologicActorVO->salary = SalaryVO::build($oMorphologicSalaryVO);

        $this->actorVO = ActorVO::build($oMorphologicActorVO);
    }
}
