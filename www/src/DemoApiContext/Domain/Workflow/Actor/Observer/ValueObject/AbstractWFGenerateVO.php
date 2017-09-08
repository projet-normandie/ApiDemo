<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Workflow\Actor\Observer\ValueObject;

use DateTime;
use DemoApiContext\Domain\ValueObject\ActorVO;
use Exception;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Generalisation\Observer\AbstractObserver;
use ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\ContactVO;
use ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\ProfileVO;
use ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\SalaryVO;
use ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\SituationVO;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Workflow\Generalisation\TraitVOChecker;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Exception\DomainException;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Manipulation\TypeHinting\TraitStdClass;
use stdClass;

/**
 * Class AbstractWFGenerateVO
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Workflow\Actor\Observer\ValueObject
 *
 * @license MIT
 */
abstract class AbstractWFGenerateVO extends AbstractObserver
{
    use TraitVOChecker;
    use TraitStdClass;

    /**
     * Builds the ActorVO using an stdClass object that contains all properties of the command object.
     *
     * @param stdClass $actorData The stdClass that contains all properties of the command object.
     * @return ActorVO
     * @throws Exception
     */
    protected function buildActorVO(stdClass $actorData): ActorVO
    {
        $aSituation = ['sex' => $actorData->sex, 'birthday' => new DateTime($actorData->birthday)];
        $aSalary = ['value' => $actorData->salary, 'currency' => $actorData->salaryCurrency];
        $aVOs = [
            'profile' => ProfileVO::build(static::buildFromDestination($actorData, ProfileVO::class)),
            'situation' => SituationVO::build(static::buildFromArray($aSituation)),
            'contact' => ContactVO::build(static::buildFromDestination($actorData, ContactVO::class)),
            'salary' => SalaryVO::build(static::buildFromArray($aSalary)),
        ];

        $this->checkVO($aVOs, DomainException::someValueObjectHaveNotBeenCreated());
        return ActorVO::build(static::buildFromArray($aVOs));
    }
}
