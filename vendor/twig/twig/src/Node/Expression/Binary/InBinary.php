<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpactor202301\Twig\Node\Expression\Binary;

use Phpactor202301\Twig\Compiler;
class InBinary extends AbstractBinary
{
    public function compile(Compiler $compiler)
    {
        $compiler->raw('twig_in_filter(')->subcompile($this->getNode('left'))->raw(', ')->subcompile($this->getNode('right'))->raw(')');
    }
    public function operator(Compiler $compiler)
    {
        return $compiler->raw('in');
    }
}
\class_alias('Phpactor202301\\Twig\\Node\\Expression\\Binary\\InBinary', 'Phpactor202301\\Twig_Node_Expression_Binary_In');
