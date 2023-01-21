<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpactor202301\Twig\Node;

use Phpactor202301\Twig\Compiler;
use Phpactor202301\Twig\Node\Expression\AbstractExpression;
/**
 * Represents a do node.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class DoNode extends Node
{
    public function __construct(AbstractExpression $expr, int $lineno, string $tag = null)
    {
        parent::__construct(['expr' => $expr], [], $lineno, $tag);
    }
    public function compile(Compiler $compiler)
    {
        $compiler->addDebugInfo($this)->write('')->subcompile($this->getNode('expr'))->raw(";\n");
    }
}
\class_alias('Phpactor202301\\Twig\\Node\\DoNode', 'Phpactor202301\\Twig_Node_Do');
