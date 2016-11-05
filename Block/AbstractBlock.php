<?php

namespace Cube\CoreBundle\Block;

use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class AbstractBlock extends BaseBlockService
{
    public function __construct($name, EngineInterface $templating)
    {
        parent::__construct($name, $templating);
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['template' => "CoreBundle:Block:base_block.html.twig"]);
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        return $this->renderResponse($blockContext->getTemplate(),
            ['settings' => $blockContext->getSettings()], $response)->setTtl(3600);
    }
}
