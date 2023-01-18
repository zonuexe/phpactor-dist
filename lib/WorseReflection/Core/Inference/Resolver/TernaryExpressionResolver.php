<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\TernaryExpression;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
class TernaryExpressionResolver implements Resolver
{
    public function resolve(NodeContextResolver $resolver, Frame $frame, Node $node) : NodeContext
    {
        \assert($node instanceof TernaryExpression);
        $condition = $resolver->resolveNode($frame, $node->condition);
        $context = NodeContextFactory::create('trinary', $node->getStartPosition(), $node->getEndPosition());
        $left = NodeContext::none();
        $right = NodeContext::none();
        /** @phpstan-ignore-next-line */
        if ($node->ifExpression) {
            $frame->applyTypeAssertions($condition->typeAssertions(), $node->ifExpression->getStartPosition());
            $left = $resolver->resolveNode($frame, $node->ifExpression);
        }
        /** @phpstan-ignore-next-line */
        if (!$node->ifExpression) {
            $left = $condition;
        }
        /** @phpstan-ignore-next-line */
        if ($node->elseExpression) {
            $frame->applyTypeAssertions($condition->typeAssertions()->negate(), $node->elseExpression->getStartPosition());
            $right = $resolver->resolveNode($frame, $node->elseExpression);
        }
        $empty = $condition->type()->isEmpty();
        if ($empty->isFalse()) {
            return $context->withType($left->type());
        }
        if ($empty->isTrue()) {
            return $context->withType($right->type());
        }
        return $context->withType($left->type()->addType($right->type()));
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\TernaryExpressionResolver', 'Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\TernaryExpressionResolver', \false);
