<?php

namespace Cube\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Entity\BaseMedia;

/**
 * @ORM\MappedSuperclass()
 */
abstract class Media extends BaseMedia
{

    protected $category;

    public function getId()
    {
        return $this->id;
    }
}
