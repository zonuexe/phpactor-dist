<?php

namespace PhpactorDist;

use PhpactorDist\Twig\Environment;
\class_exists('PhpactorDist\\Twig\\Environment');
@\trigger_error('Using the "Twig_Environment" class is deprecated since Twig version 2.7, use "Twig\\Environment" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Environment" instead */
    class Twig_Environment extends Environment
    {
    }
}
