<?php

namespace Cube\CoreBundle\Block;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\CsrfTokenManager;

class LoginBlock extends AbstractBlock
{
    use TemplateTrait;

    const CACHE_TIME = 0;
    /**
     * @var CsrfTokenManager
     */
    private $csrfTokenManager;
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct($name, EngineInterface $templating, CsrfTokenManager $csrfTokenManager, RequestStack $requestStack)
    {
        parent::__construct($name, $templating);
        $this->csrfTokenManager = $csrfTokenManager;
        $this->requestStack = $requestStack;
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'template' => $this->template
        ]);
    }

    public function getCacheKeys(BlockInterface $block)
    {
        return [
            'type' => $this->name
        ];
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $template = $blockContext->getSetting('template');
        $data = $this->getLoginFormData();

        return $this->renderResponse($template, $data, $response)->setTtl(self::CACHE_TIME);
    }

    private function getLoginFormData()
    {
        $request = $this->requestStack->getCurrentRequest();
        /* @var $request \Symfony\Component\HttpFoundation\Request */
        $session = $request->getSession();
        /* @var $session \Symfony\Component\HttpFoundation\Session\Session */

        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(Security::AUTHENTICATION_ERROR)) {
            $error = $session->get(Security::AUTHENTICATION_ERROR);
            $session->remove(Security::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        if ($error) {
            $error = $error->getMessage();
        }
        $lastUsername = (null === $session) ? '' : $session->get(Security::LAST_USERNAME);

        $csrfToken = $this->csrfTokenManager->getToken('authenticate');

        return [
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
        ];
    }

}
