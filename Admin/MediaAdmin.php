<?php

namespace Cube\CoreBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\MediaBundle\Admin\ORM\MediaAdmin as BaseMediaAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

class MediaAdmin extends BaseMediaAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('export');
    }
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);
        $formMapper->remove('category');
    }
}
