<?php

namespace Cube\CoreBundle\Block;

trait TemplateTrait
{
    private $template;

    public function setTemplate($template)
    {
        $this->template = $template;
    }
}
