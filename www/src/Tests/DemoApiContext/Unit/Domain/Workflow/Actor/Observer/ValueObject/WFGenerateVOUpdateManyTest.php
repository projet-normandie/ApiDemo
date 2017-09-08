<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Domain\Workflow\Actor\Observer\ValueObject;

use DateTime;
use DemoApiContext\Application\Cqrs\Actor\Command\UpdateManyCommand;
use DemoApiContext\Application\Cqrs\Actor\Command\UpdateOneCommand;
use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Domain\ValueObject\ActorVO;
use DemoApiContext\Domain\Workflow\Actor\Handler\UpdateManyWFHandler;
use DemoApiContext\Domain\Workflow\Actor\Observer\ValueObject\WFGenerateVOUpdateMany;
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
 * Class WFGenerateVOUpdateManyTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Domain
 * @subpackage Workflow\Actor\Observer\ValueObject
 *
 * @coversDefaultClass WFGenerateVOUpdateMany
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class WFGenerateVOUpdateManyTest extends TestCase
{
    /**
     * @var Phake_IMock Mock instance of Actor.
     * @see Actor
     */
    protected $entity;

    /**
     * @var Phake_IMock Mock instance of UpdateManyWFHandler.
     * @see UpdateManyWFHandler
     */
    protected $wfHandler;

    /**
     * @var WFGenerateVOUpdateMany
     */
    protected $wfGenerateVO;

    /**
     * @var UpdateManyCommand
     */
    protected $updateManyCommand;

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

        $updateOneCommand = new UpdateOneCommand(
            'entityId',
            'Dupont',
            'Martin',
            'F',
            '1999-04-01',
            'martin@dupont.fr',
            '0655448877',
            '0144778899',
            1.0,
            'EUR'
        );
        $this->updateManyCommand = new UpdateManyCommand([$updateOneCommand, $updateOneCommand]);
        $this->wfGenerateVO = new WFGenerateVOUpdateMany();
        $this->wfHandler = Phake::mock(UpdateManyWFHandler::class);
        $this->wfHandler->data = new stdClass();
        $this->wfHandler->data->updateOneCommands = [[$updateOneCommand, $updateOneCommand]];
        Phake::when($this->wfHandler)->getCommand()->thenReturn($this->updateManyCommand);
        Phake::when($this->wfHandler)->getData()->thenReturn($this->wfHandler->data);
    }

    /**
     * Updates for UpdateMany Command.
     *
     * @covers AbstractObserver::notify()
     */
    public function testUpdateForUpdateManyCommand(): void
    {
        $result = $this->wfGenerateVO->notify($this->wfHandler);
        static::assertInstanceOf(WFGenerateVOUpdateMany::class, $result);
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
