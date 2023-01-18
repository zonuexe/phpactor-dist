<?php

namespace Phpactor202301;

use Phpactor202301\Twig\TokenParser\IncludeTokenParser;
\class_exists('Phpactor202301\\Twig\\TokenParser\\IncludeTokenParser');
@\trigger_error('Using the "Twig_TokenParser_Include" class is deprecated since Twig version 2.7, use "Twig\\TokenParser\\IncludeTokenParser" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\TokenParser\IncludeTokenParser" instead */
    class Twig_TokenParser_Include extends IncludeTokenParser
    {
    }
}
