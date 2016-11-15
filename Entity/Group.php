<?php

namespace Cube\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseGroup as BaseGroup;

/**
 * @ORM\MappedSuperclass()
 */
abstract class Group extends BaseGroup
{
}
