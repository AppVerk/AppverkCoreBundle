<?php

namespace Cube\CoreBundle\Admin;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\MediaBundle\Admin\ORM\MediaAdmin as BaseMediaAdmin;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MediaAdmin extends BaseMediaAdmin
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('export');
    }

    protected function getTokenStorage()
    {
        return $this->tokenStorage;
    }

    public function setTokenStorage(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
}
