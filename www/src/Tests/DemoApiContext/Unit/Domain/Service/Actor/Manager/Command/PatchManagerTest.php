<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Domain\Service\Actor\Manager\Command;

use DateTime;
use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Domain\Service\Actor\Manager\Command\PatchManager;
use DemoApiContext\Domain\ValueObject\ActorVO;
use DemoApiContext\Infrastructure\Persistence\Repository\Actor\Orm\GetOneRepository;
use DemoApiContext\Infrastructure\Persistence\Repository\Actor\Orm\SaveRepository;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Factory\RepositoryFactoryInterface;
use ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\ContactVO;
use ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\ProfileVO;
use ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\SalaryVO;
use ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\SituationVO;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Generator\IdGenerator;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Logger\Generalisation\LoggerInterface;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Persistence\FieldsDefinition\FieldsDefinitionAbstract;
use stdClass;

/**
 * Class PatchManagerTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Domain
 * @subpackage Service\Actor\Manager\Command
 *
 * @coversDefaultClass PatchManager
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class PatchManagerTest extends TestCase
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

    /** @var PatchManager */
    protected $patchManager;

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
     * @var Phake_IMock Mock instance of SaveRepository.
     * @see SaveRepository
     */
    protected $saveRepository;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var ActorVO
     */
    protected $actorVO;

    /**
     * @var ProfileVO
     */
    protected $profileVO;

    /**
     * Initiates the test.
     */
    public function setUp(): void
    {
        $this->initRepositoryFactory();
        $this->initFieldsDefinition();
        $this->initVOs();
        $this->logger = Phake::mock(LoggerInterface::class);
        $this->patchManager = new PatchManager($this->repositoryFactory, $this->fieldsDefinition);
        $this->patchManager->setLogger($this->logger);
    }

    /**
     * Tests PatchManager process method.
     *
     * @covers ::process()
     */
    public function testPatch(): void
    {
        $actor = Actor::build($this->actorVO);
        Phake::when($this->getOneRepository)
            ->execute(Phake::anyParameters())
            ->thenReturn($actor);
        //change the profile to update
        $oMorphologicActorVO = new stdClass();
        $oMorphologicProfileVO = new stdClass();
        $oMorphologicProfileVO->lastName = 'lastName changed';
        $oMorphologicProfileVO->firstName = 'firstName changed';
        $this->profileVO = ProfileVO::build($oMorphologicProfileVO);
        $oMorphologicActorVO->profile = $this->profileVO;
        $oMorphologicActorVO->situation = $this->actorVO->getSituation();
        $oMorphologicActorVO->contact = $this->actorVO->getContact();
        $oMorphologicActorVO->salary = $this->actorVO->getSalary();
        $this->actorVO = ActorVO::build($oMorphologicActorVO);

        $object = new stdClass();
        $object->entityId = $this->id;
        $object->actorVO = $this->actorVO;
        $result = $this->patchManager->process($object);

        static::assertInstanceOf(Actor::class, $result);
        static::assertEquals('lastName changed', $result->getActor()->getProfile()->getLastName());
        static::assertEquals('firstName changed', $result->getActor()->getProfile()->getFirstName());
        Phake::verify($this->logger, Phake::times(1))->info(Phake::anyParameters());
        Phake::verify($this->repositoryFactory, Phake::times(1))
            ->buildRepository(RepositoryFactoryInterface::GET_ONE_REPOSITORY);
        Phake::verify($this->repositoryFactory, Phake::times(1))
            ->buildRepository(RepositoryFactoryInterface::SAVE_REPOSITORY);
        Phake::verify($this->saveRepository, Phake::times(1))->execute(Phake::anyParameters());
    }

    /**
     * Fires the Exception.
     *
     * @expectedException \ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Exception\NotFoundException
     */
    public function testPatchException(): void
    {
        Phake::when($this->getOneRepository)
            ->execute(Phake::anyParameters())
            ->thenReturn(null);

        $object = new stdClass();
        $object->entityId = 'wrong-id';
        $object->actorVO = $this->actorVO;
        $object->MovieHasActors = [];

        $this->patchManager->process($object);
    }

    /**
     * Initiates the Repository Factory.
     */
    private function initRepositoryFactory(): void
    {
        $this->repositoryFactory = Phake::mock(RepositoryFactoryInterface::class);
        $this->saveRepository = Phake::mock(SaveRepository::class);
        $this->getOneRepository = Phake::mock(GetOneRepository::class);
        Phake::when($this->repositoryFactory)
            ->buildRepository(RepositoryFactoryInterface::GET_ONE_REPOSITORY)
            ->thenReturn($this->getOneRepository);
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
        $this->id = IdGenerator::generate();
        $oMorphologicActorVO = new stdClass();

        $oMorphologicProfileVO = new stdClass();
        $oMorphologicProfileVO->lastName = 'good';
        $oMorphologicProfileVO->firstName = 'johnny';
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
