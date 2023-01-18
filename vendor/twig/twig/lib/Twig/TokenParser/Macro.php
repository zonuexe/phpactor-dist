<?php

namespace Phpactor202301;

use Phpactor202301\Twig\TokenParser\MacroTokenParser;
\class_exists('Phpactor202301\\Twig\\TokenParser\\MacroTokenParser');
@\trigger_error('Using the "Twig_TokenParser_Macro" class is deprecated since Twig version 2.7, use "Twig\\TokenParser\\MacroTokenParser" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\TokenParser\MacroTokenParser" instead */
    class Twig_TokenParser_Macro extends MacroTokenParser
    {
    }
}
