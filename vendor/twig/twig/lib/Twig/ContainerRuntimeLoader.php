<?php

namespace PhpactorDist;

use PhpactorDist\Twig\RuntimeLoader\ContainerRuntimeLoader;
\class_exists('PhpactorDist\\Twig\\RuntimeLoader\\ContainerRuntimeLoader');
@\trigger_error('Using the "Twig_ContainerRuntimeLoader" class is deprecated since Twig version 2.7, use "Twig\\RuntimeLoader\\ContainerRuntimeLoader" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\RuntimeLoader\ContainerRuntimeLoader" instead */
    class Twig_ContainerRuntimeLoader extends ContainerRuntimeLoader
    {
    }
}
