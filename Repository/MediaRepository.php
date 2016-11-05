<?php

namespace Cube\CoreBundle\Repository;

use Cube\CoreBundle\Entity\Media;
use Doctrine\ORM\EntityRepository;

class MediaRepository extends EntityRepository
{
    public function removeMedia(Media $media)
    {
        $this->getEntityManager()->remove($media);
        $this->getEntityManager()->flush($media);
    }
}
