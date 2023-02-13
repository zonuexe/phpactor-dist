<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PhpactorDist\Twig\Node\Expression\Filter;

use PhpactorDist\Twig\Compiler;
use PhpactorDist\Twig\Node\Expression\ConditionalExpression;
use PhpactorDist\Twig\Node\Expression\ConstantExpression;
use PhpactorDist\Twig\Node\Expression\FilterExpression;
use PhpactorDist\Twig\Node\Expression\GetAttrExpression;
use PhpactorDist\Twig\Node\Expression\NameExpression;
use PhpactorDist\Twig\Node\Expression\Test\DefinedTest;
use PhpactorDist\Twig\Node\Node;
/**
 * Returns the value or the default value when it is undefined or empty.
 *
 *  {{ var.foo|default('foo item on var is not defined') }}
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class DefaultFilter extends FilterExpression
{
    public function __construct(Node $node, ConstantExpression $filterName, Node $arguments, int $lineno, string $tag = null)
    {
        $default = new FilterExpression($node, new ConstantExpression('default', $node->getTemplateLine()), $arguments, $node->getTemplateLine());
        if ('default' === $filterName->getAttribute('value') && ($node instanceof NameExpression || $node instanceof GetAttrExpression)) {
            $test = new DefinedTest(clone $node, 'defined', new Node(), $node->getTemplateLine());
            $false = \count($arguments) ? $arguments->getNode(0) : new ConstantExpression('', $node->getTemplateLine());
            $node = new ConditionalExpression($test, $default, $false, $node->getTemplateLine());
        } else {
            $node = $default;
        }
        parent::__construct($node, $filterName, $arguments, $lineno, $tag);
    }
    public function compile(Compiler $compiler)
    {
        $compiler->subcompile($this->getNode('node'));
    }
}
\class_alias('PhpactorDist\\Twig\\Node\\Expression\\Filter\\DefaultFilter', 'PhpactorDist\\Twig_Node_Expression_Filter_Default');
