<?php

namespace PhpactorDist;

use PhpactorDist\Twig\NodeVisitor\EscaperNodeVisitor;
\class_exists('PhpactorDist\\Twig\\NodeVisitor\\EscaperNodeVisitor');
@\trigger_error('Using the "Twig_NodeVisitor_Escaper" class is deprecated since Twig version 2.7, use "Twig\\NodeVisitor\\EscaperNodeVisitor" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\NodeVisitor\EscaperNodeVisitor" instead */
    class Twig_NodeVisitor_Escaper extends EscaperNodeVisitor
    {
    }
}
