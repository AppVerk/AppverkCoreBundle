<?php

namespace Cube\CoreBundle\Block;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterBlock extends AbstractBlock implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    use TemplateTrait;

    const CACHE_TIME = 0;

    public function __construct($name, EngineInterface $templating)
    {
        parent::__construct($name, $templating);
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
        $data = $this->getRegisterFormData();

        return $this->renderResponse($template, $data, $response)->setTtl(self::CACHE_TIME);
    }

    private function getRegisterFormData()
    {
        $form = $this->container->get('cube.core_register_form');
        return ['form' => $form->createView()];
    }

}
