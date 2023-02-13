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
namespace PhpactorDist\Twig\Node\Expression\Binary;

use PhpactorDist\Twig\Compiler;
class DivBinary extends AbstractBinary
{
    public function operator(Compiler $compiler)
    {
        return $compiler->raw('/');
    }
}
\class_alias('PhpactorDist\\Twig\\Node\\Expression\\Binary\\DivBinary', 'PhpactorDist\\Twig_Node_Expression_Binary_Div');
