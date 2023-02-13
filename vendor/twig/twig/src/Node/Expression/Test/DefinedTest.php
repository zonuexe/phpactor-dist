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
use PhpactorDist\Twig\Error\SyntaxError;
use PhpactorDist\Twig\Node\Expression\ArrayExpression;
use PhpactorDist\Twig\Node\Expression\BlockReferenceExpression;
use PhpactorDist\Twig\Node\Expression\ConstantExpression;
use PhpactorDist\Twig\Node\Expression\FunctionExpression;
use PhpactorDist\Twig\Node\Expression\GetAttrExpression;
use PhpactorDist\Twig\Node\Expression\MethodCallExpression;
use PhpactorDist\Twig\Node\Expression\NameExpression;
use PhpactorDist\Twig\Node\Expression\TestExpression;
use PhpactorDist\Twig\Node\Node;
/**
 * Checks if a variable is defined in the current context.
 *
 *    {# defined works with variable names and variable attributes #}
 *    {% if foo is defined %}
 *        {# ... #}
 *    {% endif %}
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class DefinedTest extends TestExpression
{
    public function __construct(Node $node, string $name, ?Node $arguments, int $lineno)
    {
        if ($node instanceof NameExpression) {
            $node->setAttribute('is_defined_test', \true);
        } elseif ($node instanceof GetAttrExpression) {
            $node->setAttribute('is_defined_test', \true);
            $this->changeIgnoreStrictCheck($node);
        } elseif ($node instanceof BlockReferenceExpression) {
            $node->setAttribute('is_defined_test', \true);
        } elseif ($node instanceof FunctionExpression && 'constant' === $node->getAttribute('name')) {
            $node->setAttribute('is_defined_test', \true);
        } elseif ($node instanceof ConstantExpression || $node instanceof ArrayExpression) {
            $node = new ConstantExpression(\true, $node->getTemplateLine());
        } elseif ($node instanceof MethodCallExpression) {
            $node->setAttribute('is_defined_test', \true);
        } else {
            throw new SyntaxError('The "defined" test only works with simple variables.', $lineno);
        }
        parent::__construct($node, $name, $arguments, $lineno);
    }
    private function changeIgnoreStrictCheck(GetAttrExpression $node)
    {
        $node->setAttribute('optimizable', \false);
        $node->setAttribute('ignore_strict_check', \true);
        if ($node->getNode('node') instanceof GetAttrExpression) {
            $this->changeIgnoreStrictCheck($node->getNode('node'));
        }
    }
    public function compile(Compiler $compiler)
    {
        $compiler->subcompile($this->getNode('node'));
    }
}
\class_alias('PhpactorDist\\Twig\\Node\\Expression\\Test\\DefinedTest', 'PhpactorDist\\Twig_Node_Expression_Test_Defined');
