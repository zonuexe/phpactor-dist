<?php

namespace Phpactor202301;

use Phpactor202301\Twig\Lexer;
\class_exists('Phpactor202301\\Twig\\Lexer');
@\trigger_error('Using the "Twig_Lexer" class is deprecated since Twig version 2.7, use "Twig\\Lexer" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Lexer" instead */
    class Twig_Lexer extends Lexer
    {
    }
}