<?php

namespace Phpactor202301;

use Phpactor202301\Twig\TokenParser\ImportTokenParser;
\class_exists('Phpactor202301\\Twig\\TokenParser\\ImportTokenParser');
@\trigger_error('Using the "Twig_TokenParser_Import" class is deprecated since Twig version 2.7, use "Twig\\TokenParser\\ImportTokenParser" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\TokenParser\ImportTokenParser" instead */
    class Twig_TokenParser_Import extends ImportTokenParser
    {
    }
}
