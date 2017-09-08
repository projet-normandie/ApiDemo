<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Domain\Workflow\Actor\Observer\ValueObject;

use DateTime;
use DemoApiContext\Application\Cqrs\Actor\Command\PatchOneCommand;
use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Domain\ValueObject\ActorVO;
use DemoApiContext\Domain\Workflow\Actor\Handler\PatchOneWFHandler;
use DemoApiContext\Domain\Workflow\Actor\Observer\ValueObject\WFGenerateVOPatchOne;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\ContactVO;
use ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\ProfileVO;
use ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\SalaryVO;
use ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\SituationVO;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Generator\IdGenerator;
use stdClass;

/**
 * Class WFGenerateVOPatchOneTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Domain
 * @subpackage Workflow\Actor\Observer\ValueObject
 *
 * @coversDefaultClass WFGenerateVOPatchOne
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class WFGenerateVOPatchOneTest extends TestCase
{
    /**
     * @var Phake_IMock Mock instance of Actor.
     * @see Actor
     */
    protected $entity;

    /**
     * @var Phake_IMock Mock instance of PatchOneWFHandler.
     * @see PatchOneWFHandler
     */
    protected $wfHandler;

    /**
     * @var WFGenerateVOPatchOne
     */
    protected $wfGenerateVO;

    /**
     * @var PatchOneCommand
     */
    protected $patchOneCommand;

    /**
     * @var string $id
     */
    private $id;

    /**
     * @var ActorVO
     */
    protected $actorVO;

    /**
     * Configures the test.
     */
    protected function setUp(): void
    {
        $this->initVOs();
        $this->entity = Phake::mock(Actor::class);
        Phake::when($this->entity)->getActor()->thenReturn($this->actorVO);

        $this->patchOneCommand = new PatchOneCommand(
            'entityId',
            null,
            null,
            'F',
            null,
            null,
            null,
            '0144778899',
            null,
            null
        );
        $this->wfGenerateVO = new WFGenerateVOPatchOne();
        $this->wfHandler = Phake::mock(PatchOneWFHandler::class);
        $this->wfHandler->data = new stdClass();
        $this->wfHandler->data->entity = [$this->entity];
        Phake::when($this->wfHandler)->getCommand()->thenReturn($this->patchOneCommand);
        Phake::when($this->wfHandler)->getData()->thenReturn($this->wfHandler->data);
    }

    /**
     * Updates for PatchOne Command.
     *
     * @covers AbstractObserver::notify()
     */
    public function testUpdateForPatchOneCommand(): void
    {
        $result = $this->wfGenerateVO->notify($this->wfHandler);
        static::assertInstanceOf(WFGenerateVOPatchOne::class, $result);
    }

    /**
     * Initiates VOs.
     */
    private function initVOs(): void
    {
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

        $this->id = IdGenerator::generate();
        $this->actorVO = ActorVO::build($oMorphologicActorVO);
    }
}
