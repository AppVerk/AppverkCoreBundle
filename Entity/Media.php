<?php

namespace Cube\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Entity\BaseMedia;

/**
 * @ORM\MappedSuperclass()
 */
abstract class Media extends BaseMedia
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    protected $category;

    public function getId()
    {
        return $this->id;
    }
}
