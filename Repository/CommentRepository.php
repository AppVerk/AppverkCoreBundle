<?php

namespace Cube\CoreBundle\Repository;

use Cube\CoreBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

class CommentRepository extends EntityRepository
{
    public function getCommentsForUser(User $owner)
    {
        $query = $this
            ->createQueryBuilder('c')
            ->where('c.owner = :owner')
            ->setParameter(':owner', $owner)
            ->orderBy('c.createdAt', 'DESC');
        return $query->getQuery();
    }
}
