<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\ValueObject;

// Import for annotations.
use Doctrine\ODM\CouchDB\Mapping\Annotations as CouchDB;
//use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\ORM\Mapping as ORM;
// Import from ProjetNormandie\DddProviderBundle
use ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\ContactVO;
use ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\Generalisation\AbstractVO;
use ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\ProfileVO;
use ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\SalaryVO;
use ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\SituationVO;

/**
 * Class ActorVO
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage ValueObject
 * @final
 *
 * @ORM\Embeddable
 * ODM\EmbeddedDocument
 * @CouchDB\EmbeddedDocument
 *
 * @license MIT
 */
final class ActorVO extends AbstractVO
{
    /**
     * @var ProfileVO ValueObject that contains the profile elements.
     *
     * @JMS\Serializer\Annotation\Since("1")
     * @ORM\Embedded(class="ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\ProfileVO", columnPrefix="profile_")
     * ODM\EmbedOne(targetDocument="ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\ProfileVO")
     * @CouchDB\EmbedOne(targetDocument="ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\ProfileVO")
     */
    protected $profile;

    /**
     * @var SituationVO ValueObject that contains the situation elements.
     *
     * @JMS\Serializer\Annotation\Since("1")
     * @ORM\Embedded(class="ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\SituationVO", columnPrefix="situation_")
     * ODM\EmbedOne(targetDocument="ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\SituationVO")
     * @CouchDB\EmbedOne(targetDocument="ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\SituationVO")
     */
    protected $situation;

    /**
     * @var ContactVO ValueObject that contains the contact elements.
     *
     * @JMS\Serializer\Annotation\Since("1")
     * @ORM\Embedded(class="ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\ContactVO", columnPrefix="contact_")
     * ODM\EmbedOne(targetDocument="ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\ContactVO")
     * @CouchDB\EmbedOne(targetDocument="ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\ContactVO")
     */
    protected $contact;

    /**
     * @var SalaryVO ValueObject that contains the salary elements.
     *
     * @JMS\Serializer\Annotation\Since("2")
     * @ORM\Embedded(class="ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\SalaryVO", columnPrefix="salary_")
     * ODM\EmbedOne(targetDocument="ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\SalaryVO")
     * @CouchDB\EmbedOne(targetDocument="ProjetNormandie\DddProviderBundle\Layer\Domain\ValueObject\SalaryVO")
     */
    protected $salary;

    /**
     * Returns the profile.
     *
     * @return ProfileVO
     */
    public function getProfile(): ProfileVO
    {
        return $this->profile;
    }

    /**
     * Returns the situation.
     *
     * @return SituationVO
     */
    public function getSituation(): SituationVO
    {
        return $this->situation;
    }

    /**
     * Returns the contact.
     *
     * @return ContactVO
     */
    public function getContact(): ContactVO
    {
        return $this->contact;
    }

    /**
     * Returns the salary.
     *
     * @return SalaryVO
     */
    public function getSalary(): SalaryVO
    {
        return $this->salary;
    }
}
