<?php

namespace Cube\CoreBundle\Entity\Interfaces;

interface CubeCommentInterface
{
    /**
     * @return string
     */
    public function getIdentifierWithType();

    /**
     * @return string
     */
    public function getType();
}
