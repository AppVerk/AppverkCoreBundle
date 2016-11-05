<?php

namespace Cube\CoreBundle\Controller;

use FOS\UserBundle\Form\Model\ChangePassword;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/profile", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_USER')")
     */
    public function profileAction()
    {
        $user = $this->getUser();

        $formHandler = $this->get('cube.core_user_data_form_handler');
        $formPasswordHandler = $this->get('cube.core_change_password_form_handler');
        if ($formHandler->process($user)) {
            return $this->redirectToRoute('cube_core_user_profile');
        }
        $this->addFlash('errors', $formHandler->getFormErrors());

        $view = $this->container->getParameter('cube_core.views.profile');
        return $this->render($view, ['user' => $user, 'form' => $formHandler->getFormView(), 'formPassword' => $formPasswordHandler->getFormView()]);
    }

    /**
     * @Route("/change-password", methods={"POST"})
     * @Security("is_granted('ROLE_USER')")
     */
    public function changePasswordAction()
    {
        $user = $this->getUser();

        $formHandler = $this->get('cube.core_change_password_form_handler');
        $formHandler->setUser($user);

        if ($formHandler->process(new ChangePassword())) {
            return $this->redirectToRoute('cube_core_user_profile');
        }
        $this->addFlash('errorsLogin', $formHandler->getFormErrors());
        return $this->redirectToRoute('cube_core_user_profile');
    }
}
