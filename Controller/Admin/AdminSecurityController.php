<?php

namespace Cube\CoreBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Security;

class AdminSecurityController extends Controller
{
    public function loginAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        if ($user instanceof UserInterface) {
            $this->container->get('session')->getFlashBag()->set('sonata_user_error', 'sonata_user_already_authenticated');
            $url = $this->container->get('router')->generate('sonata_admin_dashboard');

            return new RedirectResponse($url);
        }

        $request = $this->container->get('request');
        /* @var $request \Symfony\Component\HttpFoundation\Request */
        $session = $request->getSession();
        /* @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $error = '';
        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(Security::AUTHENTICATION_ERROR)) {
            $error = $session->get(Security::AUTHENTICATION_ERROR);
        }

        if ($error) {
            $error = $error->getMessage();
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(Security::LAST_USERNAME);

        $csrfToken = $this->container->has('form.csrf_provider')
            ? $this->container->get('security.csrf.token_manager')->getToken('authenticate')
            : null;

        if ($user instanceof UserInterface && $user->isGranted('ROLE_ADMIN')) {
            $refererUri = $request->server->get('HTTP_REFERER');

            return new RedirectResponse($refererUri && $refererUri != $request->getUri() ? $refererUri : $this->container->get('router')->generate('sonata_admin_dashboard'));
        }

        return $this->container->get('templating')->renderResponse('CubeCoreBundle:Admin:Security/login.html.'.$this->container->getParameter('fos_user.template.engine'), array(
                'last_username' => $lastUsername,
                'error'         => $error,
                'csrf_token'    => $csrfToken,
                'base_template' => $this->container->get('sonata.admin.pool')->getTemplate('layout'),
                'admin_pool'    => $this->container->get('sonata.admin.pool')
            ));
    }

    public function checkAction()
    {
        return $this->redirectToRoute('cube_core_admin_adminsecurity_login');
    }

    public function logoutAction()
    {
        return $this->redirectToRoute('cube_core_admin_adminsecurity_login');
    }
}
