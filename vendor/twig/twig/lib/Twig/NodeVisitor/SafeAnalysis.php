<?php

namespace PhpactorDist;

use PhpactorDist\Twig\NodeVisitor\SafeAnalysisNodeVisitor;
\class_exists('PhpactorDist\\Twig\\NodeVisitor\\SafeAnalysisNodeVisitor');
@\trigger_error('Using the "Twig_NodeVisitor_SafeAnalysis" class is deprecated since Twig version 2.7, use "Twig\\NodeVisitor\\SafeAnalysisNodeVisitor" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\NodeVisitor\SafeAnalysisNodeVisitor" instead */
    class Twig_NodeVisitor_SafeAnalysis extends SafeAnalysisNodeVisitor
    {
    }
}
