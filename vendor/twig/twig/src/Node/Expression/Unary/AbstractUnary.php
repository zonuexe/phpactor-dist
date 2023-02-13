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
namespace PhpactorDist\Twig\Node\Expression\Unary;

use PhpactorDist\Twig\Compiler;
use PhpactorDist\Twig\Node\Expression\AbstractExpression;
use PhpactorDist\Twig\Node\Node;
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
\class_alias('PhpactorDist\\Twig\\Node\\Expression\\Unary\\AbstractUnary', 'PhpactorDist\\Twig_Node_Expression_Unary');
