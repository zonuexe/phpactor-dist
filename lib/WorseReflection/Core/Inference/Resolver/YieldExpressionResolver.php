<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\YieldExpression;
use Phpactor202301\Microsoft\PhpParser\Token;
use Phpactor202301\Microsoft\PhpParser\TokenKind;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ArrayLiteral;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\GeneratorType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\MissingType;
class YieldExpressionResolver implements Resolver
{
    public function resolve(NodeContextResolver $resolver, Frame $frame, Node $node) : NodeContext
    {
        \assert($node instanceof YieldExpression);
        $context = NodeContextFactory::forNode($node);
        $arrayElement = $node->arrayElement;
        /** @var Token */
        $from = $node->yieldOrYieldFromKeyword;
        $yieldFrom = $from->kind === TokenKind::YieldFromKeyword;
        $returnType = $frame->returnType();
        /** @phpstan-ignore-next-line No trust */
        if (!$arrayElement) {
            return $context;
        }
        $key = new MissingType();
        if ($arrayElement->elementKey) {
            $key = $resolver->resolveNode($frame, $arrayElement->elementKey)->type();
        }
        $value = new MissingType();
        /** @phpstan-ignore-next-line No trust */
        if ($arrayElement->elementValue) {
            $value = $resolver->resolveNode($frame, $arrayElement->elementValue)->type();
            if ($yieldFrom) {
                $frame->withReturnType($value);
                return $context;
            }
            // treat yield values as a seies of array shapes
            if ($value instanceof ArrayLiteral) {
                $value = $value->toShape();
            }
        }
        if ($returnType->isDefined() && $returnType instanceof GeneratorType) {
            if ($value->isDefined()) {
                $returnType = $returnType->withValue($returnType->valueType()->addType($value));
            }
            if ($key->isDefined()) {
                $returnType = $returnType->withKey($returnType->keyType()->addType($key));
            }
            $frame->withReturnType($returnType);
            return $context;
        }
        $frame->withReturnType(TypeFactory::generator($resolver->reflector(), $key, $value));
        return $context;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\YieldExpressionResolver', 'Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\YieldExpressionResolver', \false);
