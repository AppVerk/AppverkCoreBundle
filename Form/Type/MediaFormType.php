<?php

namespace Cube\CoreBundle\Form\Type;

use Sonata\MediaBundle\Form\DataTransformer\ProviderDataTransformer;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MediaFormType extends MediaType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new ProviderDataTransformer($this->pool, $this->class, [
            'provider' => $options['provider'],
            'context' => $options['context'],
            'empty_on_new' => $options['empty_on_new'],
            'new_on_update' => $options['new_on_update'],
        ]));

        $builder->add('file', 'file', [
            'property_path' => 'binaryContent'
        ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => $this->class,
            'provider' => 'sonata.media.provider.file',
            'context' => 'default',
            'empty_on_new' => true,
            'new_on_update' => true,
        ]);
    }

    public function getName()
    {
        return 'media';
    }
}
