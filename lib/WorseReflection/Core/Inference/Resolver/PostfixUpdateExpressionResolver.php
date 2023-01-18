<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\PostfixUpdateExpression;
use Phpactor202301\Microsoft\PhpParser\TokenKind;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\Literal;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\NumericType;
class PostfixUpdateExpressionResolver implements Resolver
{
    public function resolve(NodeContextResolver $resolver, Frame $frame, Node $node) : NodeContext
    {
        \assert($node instanceof PostfixUpdateExpression);
        $variable = $resolver->resolveNode($frame, $node->operand);
        $type = $variable->type();
        if ($type instanceof NumericType && $type instanceof Literal) {
            $value = $type->value();
            if (TokenKind::PlusPlusToken === $node->incrementOrDecrementOperator->kind) {
                return $variable->withType($type->withValue(++$value));
            }
            if (TokenKind::MinusMinusToken === $node->incrementOrDecrementOperator->kind) {
                return $variable->withType($type->withValue(--$value));
            }
        }
        return $variable;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\PostfixUpdateExpressionResolver', 'Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\PostfixUpdateExpressionResolver', \false);