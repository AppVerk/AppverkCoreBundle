<?php

namespace Cube\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use JMS\Serializer\Annotation as Serializer;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints as Constraint;


/**
 * @ORM\MappedSuperclass()
 */
abstract class User extends BaseUser
{
    /**
     * Hook SoftDeleteable behavior
     * updates deletedAt field
     */
    use SoftDeleteableEntity;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $banReason;

    /**
     * @var integer
     *
     * @ORM\Column(type="bigint", nullable=true)
     */
    protected $lastIp;

    public function __construct()
    {
        parent::__construct();
        $this->groups = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param mixed $groups
     * @return User
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
        return $this;
    }

    /**
     * @return string
     */
    public function getBanReason()
    {
        return $this->banReason;
    }

    /**
     * @param string $banReason
     * @return User
     */
    public function setBanReason($banReason)
    {
        $this->banReason = $banReason;
        return $this;
    }

    /**
     * @return int
     */
    public function getLastIp()
    {
        return $this->lastIp;
    }

    /**
     * @param int $lastIp
     * @return User
     */
    public function setLastIp($lastIp)
    {
        $this->lastIp = $lastIp;
        return $this;
    }

    public function getUserFullName()
    {
        return ($this->firstname && $this->lastname) ? $this->firstname . ' ' . $this->lastname : $this->username;
    }

}
