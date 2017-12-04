<?php
namespace AppBundle\Entity\User;

use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 *
 * @ORM\Table(name="user__user")
 *
 * @UniqueEntity(
 *     fields="email",
 *     message="This email is already used, please try another one.",
 *     groups={"register", "admin"}
 * )
 *
 *
 */
class User extends BaseUser implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    protected $id;

    /**
     * @var string
     *
     * @JMS\Expose
     * @JMS\Groups({"public"})
     */
    protected $email;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"email"}, unique=true, updatable=true, separator="-")
     *
     * @JMS\Expose()
     * @JMS\Groups({"public"})
     */
    protected $username;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"username"}, unique=true, updatable=true)
     */
    protected $usernameCanonical;


    /**
     * @var array
     *
     * @JMS\Expose()
     * @JMS\Groups({"public"})
     */
    protected $roles;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     *
     * @JMS\Expose()
     */
    protected $createdAt;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User\Profile", cascade={"remove", "persist"})
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @JMS\Expose()
     * @JMS\Groups({"public"})
     */
    protected $profile;

    /**
     * @return mixed
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param mixed $profile
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function createTimestamps()
    {
        if($this->getCreatedAt() == null)
        {
            $this->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        }
    }
}