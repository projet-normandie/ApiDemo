<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Domain\Workflow\Actor\Observer\ValueObject;

use DateTime;
use DemoApiContext\Application\Cqrs\Actor\Command\PatchManyCommand;
use DemoApiContext\Application\Cqrs\Actor\Command\PatchOneCommand;
use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Domain\ValueObject\ActorVO;
use DemoApiContext\Domain\Workflow\Actor\Handler\PatchManyWFHandler;
use DemoApiContext\Domain\Workflow\Actor\Observer\ValueObject\WFGenerateVOPatchMany;
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
 * Class WFGenerateVOPatchManyTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Domain
 * @subpackage Workflow\Actor\Observer\ValueObject
 *
 * @coversDefaultClass WFGenerateVOPatchMany
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class WFGenerateVOPatchManyTest extends TestCase
{
    /**
     * @var Phake_IMock Mock instance of Actor.
     * @see Actor
     */
    protected $entity;

    /**
     * @var Phake_IMock Mock instance of PatchManyWFHandler.
     * @see PatchManyWFHandler
     */
    protected $wfHandler;

    /**
     * @var WFGenerateVOPatchMany
     */
    protected $wfGenerateVO;

    /**
     * @var PatchManyCommand
     */
    protected $patchManyCommand;

    /**
     * @var string $id
     */
    protected $id;

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

        $patchOneCommand = new PatchOneCommand(
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
        $this->patchManyCommand = new PatchManyCommand([$patchOneCommand, $patchOneCommand]);
        $this->wfGenerateVO = new WFGenerateVOPatchMany();
        $this->wfHandler = Phake::mock(PatchManyWFHandler::class);
        $this->wfHandler->data = new stdClass();
        $this->wfHandler->data->patchOneCommands = [[$patchOneCommand, $patchOneCommand]];
        $this->wfHandler->data->entities = [[$this->entity, $this->entity]];
        Phake::when($this->wfHandler)->getCommand()->thenReturn($this->patchManyCommand);
        Phake::when($this->wfHandler)->getData()->thenReturn($this->wfHandler->data);
    }

    /**
     * Updates for PatchMany Command.
     *
     * @covers AbstractObserver::notify()
     */
    public function testUpdateForPatchManyCommand(): void
    {
        $result = $this->wfGenerateVO->notify($this->wfHandler);
        static::assertInstanceOf(WFGenerateVOPatchMany::class, $result);
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
