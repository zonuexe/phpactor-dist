<?php

namespace PhpactorDist;

use PhpactorDist\Twig\ExtensionSet;
\class_exists('PhpactorDist\\Twig\\ExtensionSet');
@\trigger_error('Using the "Twig_ExtensionSet" class is deprecated since Twig version 2.7, use "Twig\\ExtensionSet" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\ExtensionSet" instead */
    class Twig_ExtensionSet extends ExtensionSet
    {
    }
}
