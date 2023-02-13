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
 * Checks if a number is odd.
 *
 *  {{ var is odd }}
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class OddTest extends TestExpression
{
    public function compile(Compiler $compiler)
    {
        $compiler->raw('(')->subcompile($this->getNode('node'))->raw(' % 2 != 0')->raw(')');
    }
}
\class_alias('PhpactorDist\\Twig\\Node\\Expression\\Test\\OddTest', 'PhpactorDist\\Twig_Node_Expression_Test_Odd');
