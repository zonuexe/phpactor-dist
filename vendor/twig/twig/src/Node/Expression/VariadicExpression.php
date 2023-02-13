<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PhpactorDist\Twig\Node\Expression;

use PhpactorDist\Twig\Compiler;
class VariadicExpression extends ArrayExpression
{
    public function compile(Compiler $compiler)
    {
        $compiler->raw('...');
        parent::compile($compiler);
    }
}
