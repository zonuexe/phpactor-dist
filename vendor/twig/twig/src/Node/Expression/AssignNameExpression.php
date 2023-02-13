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
namespace PhpactorDist\Twig\Node\Expression;

use PhpactorDist\Twig\Compiler;
class AssignNameExpression extends NameExpression
{
    public function compile(Compiler $compiler)
    {
        $compiler->raw('$context[')->string($this->getAttribute('name'))->raw(']');
    }
}
\class_alias('PhpactorDist\\Twig\\Node\\Expression\\AssignNameExpression', 'PhpactorDist\\Twig_Node_Expression_AssignName');
