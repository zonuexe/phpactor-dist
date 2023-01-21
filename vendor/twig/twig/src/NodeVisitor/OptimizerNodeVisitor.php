<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpactor202301\Twig\NodeVisitor;

use Phpactor202301\Twig\Environment;
use Phpactor202301\Twig\Node\BlockReferenceNode;
use Phpactor202301\Twig\Node\Expression\BlockReferenceExpression;
use Phpactor202301\Twig\Node\Expression\ConstantExpression;
use Phpactor202301\Twig\Node\Expression\FilterExpression;
use Phpactor202301\Twig\Node\Expression\FunctionExpression;
use Phpactor202301\Twig\Node\Expression\GetAttrExpression;
use Phpactor202301\Twig\Node\Expression\NameExpression;
use Phpactor202301\Twig\Node\Expression\ParentExpression;
use Phpactor202301\Twig\Node\ForNode;
use Phpactor202301\Twig\Node\IncludeNode;
use Phpactor202301\Twig\Node\Node;
use Phpactor202301\Twig\Node\PrintNode;
/**
 * Tries to optimize the AST.
 *
 * This visitor is always the last registered one.
 *
 * You can configure which optimizations you want to activate via the
 * optimizer mode.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class OptimizerNodeVisitor extends AbstractNodeVisitor
{
    public const OPTIMIZE_ALL = -1;
    public const OPTIMIZE_NONE = 0;
    public const OPTIMIZE_FOR = 2;
    public const OPTIMIZE_RAW_FILTER = 4;
    // obsolete, does not do anything
    public const OPTIMIZE_VAR_ACCESS = 8;
    private $loops = [];
    private $loopsTargets = [];
    private $optimizers;
    /**
     * @param int $optimizers The optimizer mode
     */
    public function __construct(int $optimizers = -1)
    {
        if (!\is_int($optimizers) || $optimizers > (self::OPTIMIZE_FOR | self::OPTIMIZE_RAW_FILTER | self::OPTIMIZE_VAR_ACCESS)) {
            throw new \InvalidArgumentException(\sprintf('Optimizer mode "%s" is not valid.', $optimizers));
        }
        $this->optimizers = $optimizers;
    }
    protected function doEnterNode(Node $node, Environment $env)
    {
        if (self::OPTIMIZE_FOR === (self::OPTIMIZE_FOR & $this->optimizers)) {
            $this->enterOptimizeFor($node, $env);
        }
        return $node;
    }
    protected function doLeaveNode(Node $node, Environment $env)
    {
        if (self::OPTIMIZE_FOR === (self::OPTIMIZE_FOR & $this->optimizers)) {
            $this->leaveOptimizeFor($node, $env);
        }
        if (self::OPTIMIZE_RAW_FILTER === (self::OPTIMIZE_RAW_FILTER & $this->optimizers)) {
            $node = $this->optimizeRawFilter($node, $env);
        }
        $node = $this->optimizePrintNode($node, $env);
        return $node;
    }
    /**
     * Optimizes print nodes.
     *
     * It replaces:
     *
     *   * "echo $this->render(Parent)Block()" with "$this->display(Parent)Block()"
     */
    private function optimizePrintNode(Node $node, Environment $env) : Node
    {
        if (!$node instanceof PrintNode) {
            return $node;
        }
        $exprNode = $node->getNode('expr');
        if ($exprNode instanceof BlockReferenceExpression || $exprNode instanceof ParentExpression) {
            $exprNode->setAttribute('output', \true);
            return $exprNode;
        }
        return $node;
    }
    /**
     * Removes "raw" filters.
     */
    private function optimizeRawFilter(Node $node, Environment $env) : Node
    {
        if ($node instanceof FilterExpression && 'raw' == $node->getNode('filter')->getAttribute('value')) {
            return $node->getNode('node');
        }
        return $node;
    }
    /**
     * Optimizes "for" tag by removing the "loop" variable creation whenever possible.
     */
    private function enterOptimizeFor(Node $node, Environment $env)
    {
        if ($node instanceof ForNode) {
            // disable the loop variable by default
            $node->setAttribute('with_loop', \false);
            \array_unshift($this->loops, $node);
            \array_unshift($this->loopsTargets, $node->getNode('value_target')->getAttribute('name'));
            \array_unshift($this->loopsTargets, $node->getNode('key_target')->getAttribute('name'));
        } elseif (!$this->loops) {
            // we are outside a loop
            return;
        } elseif ($node instanceof NameExpression && 'loop' === $node->getAttribute('name')) {
            $node->setAttribute('always_defined', \true);
            $this->addLoopToCurrent();
        } elseif ($node instanceof NameExpression && \in_array($node->getAttribute('name'), $this->loopsTargets)) {
            $node->setAttribute('always_defined', \true);
        } elseif ($node instanceof BlockReferenceNode || $node instanceof BlockReferenceExpression) {
            $this->addLoopToCurrent();
        } elseif ($node instanceof IncludeNode && !$node->getAttribute('only')) {
            $this->addLoopToAll();
        } elseif ($node instanceof FunctionExpression && 'include' === $node->getAttribute('name') && (!$node->getNode('arguments')->hasNode('with_context') || \false !== $node->getNode('arguments')->getNode('with_context')->getAttribute('value'))) {
            $this->addLoopToAll();
        } elseif ($node instanceof GetAttrExpression && (!$node->getNode('attribute') instanceof ConstantExpression || 'parent' === $node->getNode('attribute')->getAttribute('value')) && (\true === $this->loops[0]->getAttribute('with_loop') || $node->getNode('node') instanceof NameExpression && 'loop' === $node->getNode('node')->getAttribute('name'))) {
            $this->addLoopToAll();
        }
    }
    /**
     * Optimizes "for" tag by removing the "loop" variable creation whenever possible.
     */
    private function leaveOptimizeFor(Node $node, Environment $env)
    {
        if ($node instanceof ForNode) {
            \array_shift($this->loops);
            \array_shift($this->loopsTargets);
            \array_shift($this->loopsTargets);
        }
    }
    private function addLoopToCurrent()
    {
        $this->loops[0]->setAttribute('with_loop', \true);
    }
    private function addLoopToAll()
    {
        foreach ($this->loops as $loop) {
            $loop->setAttribute('with_loop', \true);
        }
    }
    public function getPriority()
    {
        return 255;
    }
}
\class_alias('Phpactor202301\\Twig\\NodeVisitor\\OptimizerNodeVisitor', 'Phpactor202301\\Twig_NodeVisitor_Optimizer');
