<?php

namespace PhpactorDist;

use PhpactorDist\Twig\TwigFilter;
\class_exists('PhpactorDist\\Twig\\TwigFilter');
@\trigger_error('Using the "Twig_Filter" class is deprecated since Twig version 2.7, use "Twig\\TwigFilter" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\TwigFilter" instead */
    class Twig_Filter extends TwigFilter
    {
    }
}
