<?php

namespace Cube\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseTag as BaseTag;

/**
 * @ORM\MappedSuperclass()
 */
class Tag extends BaseTag
{
}
