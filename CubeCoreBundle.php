<?php

namespace Cube\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CubeCoreBundle extends Bundle
{
    public function getParent()
    {
        return 'SonataUserBundle';
    }
}
