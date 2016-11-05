<?php

namespace Cube\CoreBundle\Form\Type;

use FOS\UserBundle\Form\Type\ChangePasswordFormType as BaseChangePasswordFormType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChangePasswordType extends BaseChangePasswordFormType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'FOS\UserBundle\Form\Model\ChangePassword',
            'intention' => 'change_password',
            'validation_groups' => ['ChangePassword', 'Default']
        ]);
    }

    public function getName()
    {
        return 'user_change_password';
    }
}
