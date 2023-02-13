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
class ConstantExpression extends AbstractExpression
{
    public function __construct($value, int $lineno)
    {
        parent::__construct([], ['value' => $value], $lineno);
    }
    public function compile(Compiler $compiler)
    {
        $compiler->repr($this->getAttribute('value'));
    }
}
\class_alias('PhpactorDist\\Twig\\Node\\Expression\\ConstantExpression', 'PhpactorDist\\Twig_Node_Expression_Constant');
