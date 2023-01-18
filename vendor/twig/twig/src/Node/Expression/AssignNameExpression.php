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
namespace Phpactor202301\Twig\Node\Expression;

use Phpactor202301\Twig\Compiler;
class AssignNameExpression extends NameExpression
{
    public function compile(Compiler $compiler)
    {
        $compiler->raw('$context[')->string($this->getAttribute('name'))->raw(']');
    }
}
\class_alias('Phpactor202301\\Twig\\Node\\Expression\\AssignNameExpression', 'Phpactor202301\\Twig_Node_Expression_AssignName');
