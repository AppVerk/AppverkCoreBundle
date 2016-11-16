<?php

namespace Cube\CoreBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\MediaBundle\Admin\ORM\MediaAdmin as Admin;
use Sonata\MediaBundle\Form\DataTransformer\ProviderDataTransformer;

class MediaAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields( FormMapper $formMapper ) {
        $media = $this->getSubject();

        if ( ! $media ) {
            $media = $this->getNewInstance();
        }

        if ( ! $media || ! $media->getProviderName() ) {
            return;
        }

        $formMapper->add( 'providerName', 'hidden' );

        $formMapper->getFormBuilder()->addModelTransformer( new ProviderDataTransformer( $this->pool, $this->getClass() ), true );

        $provider = $this->pool->getProvider( $media->getProviderName() );

        if ( $media->getId() ) {
            $provider->buildEditForm( $formMapper );
        } else {
            $provider->buildCreateForm( $formMapper );
        }

    }

}
