<?php

namespace Cube\CoreBundle\Form\Type;

use Cube\CoreBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('about')
            ->add('state', ChoiceType::class, [
                'choices' => User::getStateOptions()
            ])
            ->add('cancer_type', TextType::class, [
                'property_path' => 'cancerType'
            ])
            ->add('profession')
            ->add('skype')
            ->add('gadu_gadu', TextType::class, [
                'property_path' => 'gaduGadu'
            ])
            ->add('website')
            ->add('avatar', 'media', [
                'provider' => 'sonata.media.provider.image',
                'context' => 'avatar',
                'required' => false,
                'attr' => ['id' => 'fileUpload']
            ])
            ->add('video');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Cube\CoreBundle\Entity\User',
            'cascade_validation' => true,
        ]);
    }

    public function getName()
    {
        return 'user_data';
    }
}
