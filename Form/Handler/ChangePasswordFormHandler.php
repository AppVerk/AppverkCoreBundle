<?php

namespace Cube\CoreBundle\Form\Handler;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class ChangePasswordFormHandler extends FormHandler
{
    /** @var UserManagerInterface */
    private $userManager;

    /** @var UserInterface */
    private $user;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function setUser(UserInterface $user = null)
    {
        $this->user = $user;
    }

    protected function doProcessForm()
    {
        if (null === $this->user) {
            throw new UsernameNotFoundException;
        }
        try {
            $this->user->setPlainPassword($this->getNewPassword());
            $this->userManager->updateUser($this->user);
        } catch (\Exception $e) {
            $this->getForm()->addError(new FormError('Niepoprawne aktualne hasło lub hasła nie pasują do siebie'));
            return false;
        }

        return true;
    }

    protected function getNewPassword()
    {
        return $this->form->getData()->new;
    }
}
