<?php

namespace Phpactor202301;

use Phpactor202301\Twig\TokenParser\WithTokenParser;
\class_exists('Phpactor202301\\Twig\\TokenParser\\WithTokenParser');
@\trigger_error('Using the "Twig_TokenParser_With" class is deprecated since Twig version 2.7, use "Twig\\TokenParser\\WithTokenParser" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\TokenParser\WithTokenParser" instead */
    class Twig_TokenParser_With extends WithTokenParser
    {
    }
}
