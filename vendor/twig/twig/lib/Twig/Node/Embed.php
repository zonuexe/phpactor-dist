<?php

namespace PhpactorDist;

use PhpactorDist\Twig\Node\EmbedNode;
\class_exists('PhpactorDist\\Twig\\Node\\EmbedNode');
@\trigger_error('Using the "Twig_Node_Embed" class is deprecated since Twig version 2.7, use "Twig\\Node\\EmbedNode" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Node\EmbedNode" instead */
    class Twig_Node_Embed extends EmbedNode
    {
    }
}
