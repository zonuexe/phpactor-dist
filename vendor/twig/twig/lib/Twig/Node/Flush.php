<?php

namespace PhpactorDist;

use PhpactorDist\Twig\Node\FlushNode;
\class_exists('PhpactorDist\\Twig\\Node\\FlushNode');
@\trigger_error('Using the "Twig_Node_Flush" class is deprecated since Twig version 2.7, use "Twig\\Node\\FlushNode" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Node\FlushNode" instead */
    class Twig_Node_Flush extends FlushNode
    {
    }
}
