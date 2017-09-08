<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Entity;

use DemoApiContext\Domain\ValueObject\ActorVO;
// Import for annotations.
use Doctrine\ORM\Mapping as ORM;
// Import from ProjetNormandie\DddProviderBundle
use ProjetNormandie\DddProviderBundle\Layer\Domain\Generalisation\Entity\EntityInterface;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Generator\IdGenerator;

/**
 * Class Actor
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Entity
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="Actor")
 *
 * @license MIT
 */
class Actor implements EntityInterface
{
    /**
     * @var string Unique identifier of the Actor.
     *
     * @JMS\Serializer\Annotation\Since("1")
     * @ORM\Column(type="string", name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $id;

    /**
     * @var ActorVO ValueObject that contains all data of the Actor entity.
     *
     * @JMS\Serializer\Annotation\Since("1")
     * @ORM\Embedded(class="DemoApiContext\Domain\ValueObject\ActorVO", columnPrefix="")
     */
    protected $actor;

    /**
     * Builds the entity based on the value object associated.
     *
     * @param ActorVO $actor
     * @return Actor
     */
    public static function build(ActorVO $actor): Actor
    {
        return new self($actor);
    }

    /**
     * Actor constructor.
     *
     * @param ActorVO $actor
     */
    protected function __construct(ActorVO $actor)
    {
        $this->id = IdGenerator::generate();
        $this->setActor($actor);
    }

    /**
     * Returns the id.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Sets the id.
     *
     * @param string $id
     * @return Actor
     */
    public function setId(string $id): Actor
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Returns the actor.
     *
     * @return ActorVO
     */
    public function getActor(): ActorVO
    {
        return $this->actor;
    }

    /**
     * Sets the actor.
     *
     * @param ActorVO $actor
     * @return Actor
     */
    public function setActor(ActorVO $actor): Actor
    {
        $this->actor = $actor;
        return $this;
    }
}
