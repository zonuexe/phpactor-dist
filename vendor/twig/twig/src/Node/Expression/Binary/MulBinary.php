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
namespace Phpactor202301\Twig\Node\Expression\Binary;

use Phpactor202301\Twig\Compiler;
class MulBinary extends AbstractBinary
{
    public function operator(Compiler $compiler)
    {
        return $compiler->raw('*');
    }
}
\class_alias('Phpactor202301\\Twig\\Node\\Expression\\Binary\\MulBinary', 'Phpactor202301\\Twig_Node_Expression_Binary_Mul');