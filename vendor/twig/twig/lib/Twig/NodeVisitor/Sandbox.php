<?php

namespace Phpactor202301;

use Phpactor202301\Twig\NodeVisitor\SandboxNodeVisitor;
\class_exists('Phpactor202301\\Twig\\NodeVisitor\\SandboxNodeVisitor');
@\trigger_error('Using the "Twig_NodeVisitor_Sandbox" class is deprecated since Twig version 2.7, use "Twig\\NodeVisitor\\SandboxNodeVisitor" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\NodeVisitor\SandboxNodeVisitor" instead */
    class Twig_NodeVisitor_Sandbox extends SandboxNodeVisitor
    {
    }
}
