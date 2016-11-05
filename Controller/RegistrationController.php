<?php

namespace Cube\CoreBundle\Controller;

use Cube\CoreBundle\Form\Model\Register;
use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccountStatusException;

/**
 * @Route("/register")
 */
class RegistrationController extends Controller
{
    /**
     * @Route("/", methods={"POST"})
     */
    public function registerAction()
    {
        $formHandler = $this->get('cube.core_register_form_handler');
        if ($formHandler->process(new Register())) {
            $this->addFlash('message', 'Wysłalismy na podany adres e-mail wiadomość, w celu potwierdzenia konta kliknij na link w treści wiadomości');
            return new RedirectResponse('/#modal-register');
        }
        $this->addFlash('errors', $formHandler->getFormErrors());
        return new RedirectResponse('/#modal-register');
    }

    /**
     * @Route("confirm", methods={"GET"}, name="fos_user_registration_confirm")
     */
    public function confirmAction(Request $request)
    {
        $token = $request->query->get('token');
        $user = $this->container->get('fos_user.user_manager')->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $user->setLocked(false);
        $user->setLastLogin(new \DateTime());

        $this->container->get('fos_user.user_manager')->updateUser($user);
        $response = new RedirectResponse('/');
        $this->authenticateUser($user, $response);

        return $response;
    }

    protected function authenticateUser(UserInterface $user, Response $response)
    {
        try {
            $this->container->get('fos_user.security.login_manager')->loginUser(
                $this->container->getParameter('fos_user.firewall_name'),
                $user,
                $response);
        } catch (AccountStatusException $ex) {
            // We simply do not authenticate users which do not pass the user
            // checker (not enabled, expired, etc.).
        }
    }
}
