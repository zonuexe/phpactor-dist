<?php

namespace Phpactor202301;

use Phpactor202301\Twig\Loader\ArrayLoader;
\class_exists('Phpactor202301\\Twig\\Loader\\ArrayLoader');
@\trigger_error('Using the "Twig_Loader_Array" class is deprecated since Twig version 2.7, use "Twig\\Loader\\ArrayLoader" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Loader\ArrayLoader" instead */
    class Twig_Loader_Array extends ArrayLoader
    {
    }
}
