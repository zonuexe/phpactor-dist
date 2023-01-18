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
namespace Phpactor202301\Twig\Node\Expression\Unary;

use Phpactor202301\Twig\Compiler;
use Phpactor202301\Twig\Node\Expression\AbstractExpression;
use Phpactor202301\Twig\Node\Node;
abstract class AbstractUnary extends AbstractExpression
{
    public function __construct(Node $node, int $lineno)
    {
        parent::__construct(['node' => $node], [], $lineno);
    }
    public function compile(Compiler $compiler)
    {
        $compiler->raw(' ');
        $this->operator($compiler);
        $compiler->subcompile($this->getNode('node'));
    }
    public abstract function operator(Compiler $compiler);
}
\class_alias('Phpactor202301\\Twig\\Node\\Expression\\Unary\\AbstractUnary', 'Phpactor202301\\Twig_Node_Expression_Unary');
