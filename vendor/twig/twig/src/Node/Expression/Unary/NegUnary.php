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
namespace Phpactor202301\Twig\Node\Expression\Unary;

use Phpactor202301\Twig\Compiler;
class NegUnary extends AbstractUnary
{
    public function operator(Compiler $compiler)
    {
        $compiler->raw('-');
    }
}
\class_alias('Phpactor202301\\Twig\\Node\\Expression\\Unary\\NegUnary', 'Phpactor202301\\Twig_Node_Expression_Unary_Neg');
