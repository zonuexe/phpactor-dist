<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PhpactorDist\Twig\Node\Expression\Test;

use PhpactorDist\Twig\Compiler;
use PhpactorDist\Twig\Node\Expression\TestExpression;
/**
 * Checks if a variable is divisible by a number.
 *
 *  {% if loop.index is divisible by(3) %}
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class DivisiblebyTest extends TestExpression
{
    public function compile(Compiler $compiler)
    {
        $compiler->raw('(0 == ')->subcompile($this->getNode('node'))->raw(' % ')->subcompile($this->getNode('arguments')->getNode(0))->raw(')');
    }
}
\class_alias('PhpactorDist\\Twig\\Node\\Expression\\Test\\DivisiblebyTest', 'PhpactorDist\\Twig_Node_Expression_Test_Divisibleby');
