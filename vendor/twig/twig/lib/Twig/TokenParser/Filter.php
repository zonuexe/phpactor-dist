<?php

namespace Phpactor202301;

use Phpactor202301\Twig\TokenParser\FilterTokenParser;
\class_exists('Phpactor202301\\Twig\\TokenParser\\FilterTokenParser');
@\trigger_error('Using the "Twig_TokenParser_Filter" class is deprecated since Twig version 2.7, use "Twig\\TokenParser\\FilterTokenParser" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\TokenParser\FilterTokenParser" instead */
    class Twig_TokenParser_Filter extends FilterTokenParser
    {
    }
}