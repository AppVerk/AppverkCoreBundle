<?php

namespace Cube\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseCategory;

/**
 * @ORM\MappedSuperclass()
 */
abstract class Category extends BaseCategory
{
}
