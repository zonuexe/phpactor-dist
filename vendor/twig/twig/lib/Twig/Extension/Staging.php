<?php

namespace PhpactorDist;

use PhpactorDist\Twig\Extension\StagingExtension;
\class_exists('PhpactorDist\\Twig\\Extension\\StagingExtension');
@\trigger_error('Using the "Twig_Extension_Staging" class is deprecated since Twig version 2.7, use "Twig\\Extension\\StagingExtension" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Extension\StagingExtension" instead */
    class Twig_Extension_Staging extends StagingExtension
    {
    }
}
