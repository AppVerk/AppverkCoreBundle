<?php

namespace Cube\CoreBundle\Form\Handler;

use Cube\CoreBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserDataHandler extends FormHandler
{

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected function doProcessForm()
    {
        /** @var User $user */
        $user = $this->getForm()->getData();

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return true;
    }
}
