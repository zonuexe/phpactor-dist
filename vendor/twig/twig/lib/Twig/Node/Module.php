<?php

namespace PhpactorDist;

use PhpactorDist\Twig\Node\ModuleNode;
\class_exists('PhpactorDist\\Twig\\Node\\ModuleNode');
@\trigger_error('Using the "Twig_Node_Module" class is deprecated since Twig version 2.7, use "Twig\\Node\\ModuleNode" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Node\ModuleNode" instead */
    class Twig_Node_Module extends ModuleNode
    {
    }
}
