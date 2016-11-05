<?php

namespace Cube\CoreBundle\Form\Handler;

use Cube\CoreBundle\Entity\User;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\Form\FormError;

class RegisterFormHandler extends FormHandler
{
    /** @var UserManagerInterface */
    private $userManager;
    /**
     * @var MailerInterface
     */
    private $mailer;
    /**
     * @var TokenGeneratorInterface
     */
    private $tokenGenerator;

    public function __construct(UserManagerInterface $userManager, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator)
    {
        $this->userManager = $userManager;
        $this->mailer = $mailer;
        $this->tokenGenerator = $tokenGenerator;
    }

    protected function doProcessForm()
    {
        /** @var User $user */
        $userData = $this->getForm()->getData();

        $email_exist = $this->userManager->findUserByEmail($userData->getEmail());
        $login_exist = $this->userManager->findUserByUsername($userData->getUsername());

        if($email_exist){
            $this->getForm()->addError(new FormError('Adres email jest już używany'));
            return false;
        }
        if($login_exist){
            $this->getForm()->addError(new FormError('Login jest już używany'));
            return false;
        }

        $user = $this->userManager->createUser();
        $user->setUsername($userData->getUsername());
        $user->setEmail($userData->getEmail());
        $user->setEmailCanonical($userData->getEmail());
        $user->setLocked(true);

        $user->setPlainPassword($userData->getPlainPassword());

        $this->sendActivationEmail($user);

        $this->userManager->updateUser($user);

        return true;
    }

    protected function sendActivationEmail(UserInterface $user)
    {
        $user->setEnabled(false);
        if (null === $user->getConfirmationToken()) {
            $user->setConfirmationToken($this->tokenGenerator->generateToken());
        }
        $this->mailer->sendConfirmationEmailMessage($user);
    }
}
