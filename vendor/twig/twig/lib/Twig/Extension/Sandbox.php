<?php

namespace PhpactorDist;

use PhpactorDist\Twig\Extension\SandboxExtension;
\class_exists('PhpactorDist\\Twig\\Extension\\SandboxExtension');
@\trigger_error('Using the "Twig_Extension_Sandbox" class is deprecated since Twig version 2.7, use "Twig\\Extension\\SandboxExtension" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Extension\SandboxExtension" instead */
    class Twig_Extension_Sandbox extends SandboxExtension
    {
    }
}
