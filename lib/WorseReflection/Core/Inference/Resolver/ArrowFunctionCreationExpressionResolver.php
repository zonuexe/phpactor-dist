<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ArrowFunctionCreationExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Parameter;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ClosureType;
use Phpactor202301\Phpactor\WorseReflection\Core\Util\NodeUtil;
class ArrowFunctionCreationExpressionResolver implements Resolver
{
    public function resolve(NodeContextResolver $resolver, Frame $frame, Node $node) : NodeContext
    {
        \assert($node instanceof ArrowFunctionCreationExpression);
        $returnType = NodeUtil::typeFromQualfiedNameLike($resolver->reflector(), $node, $node->returnTypeList);
        $args = [];
        /** @phpstan-ignore-next-line [TR] No trust */
        if ($node->parameters) {
            foreach ($node->parameters->getChildNodes() as $parameter) {
                if (!$parameter instanceof Parameter) {
                    continue;
                }
                $args[] = $resolver->resolveNode($frame, $parameter)->type();
            }
        }
        if (!$returnType->isDefined()) {
            $returnType = $resolver->resolveNode($frame, $node->resultExpression)->type()->generalize();
        }
        return NodeContextFactory::create($node->getText(), $node->getStartPosition(), $node->getEndPosition(), ['type' => new ClosureType($resolver->reflector(), $args, $returnType)]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\ArrowFunctionCreationExpressionResolver', 'Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\ArrowFunctionCreationExpressionResolver', \false);
