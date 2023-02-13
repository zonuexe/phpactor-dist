<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 * (c) Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PhpactorDist\Twig\Node\Expression\Unary;

use PhpactorDist\Twig\Compiler;
class NotUnary extends AbstractUnary
{
    public function operator(Compiler $compiler)
    {
        $compiler->raw('!');
    }
}
\class_alias('PhpactorDist\\Twig\\Node\\Expression\\Unary\\NotUnary', 'PhpactorDist\\Twig_Node_Expression_Unary_Not');
