<?php

namespace Cube\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, [
                'label' => 'form.username', 'translation_domain' => 'FOSUserBundle'
            ])
            ->add('email', 'email', [
                'label' => 'form.email', 'translation_domain' => 'FOSUserBundle'
            ])
            ->add('plainPassword', 'repeated', [
                'type' => 'password',
                'options' => ['translation_domain' => 'FOSUserBundle'],
                'first_options' => ['label' => 'form.password'],
                'second_options' => ['label' => 'form.password_confirmation'],
                'invalid_message' => 'fos_user.password.mismatch',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Cube\CoreBundle\Form\Model\Register',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'intention' => $this->getName(),
        ]);
    }

    public function getName()
    {
        return 'user_register';
    }
}
