<?php

namespace Phpactor202301;

use Phpactor202301\Twig\Loader\ChainLoader;
\class_exists('Phpactor202301\\Twig\\Loader\\ChainLoader');
@\trigger_error('Using the "Twig_Loader_Chain" class is deprecated since Twig version 2.7, use "Twig\\Loader\\ChainLoader" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Loader\ChainLoader" instead */
    class Twig_Loader_Chain extends ChainLoader
    {
    }
}
