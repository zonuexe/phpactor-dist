<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\AnonymousFunctionCreationExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Parameter;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ClosureType;
use Phpactor202301\Phpactor\WorseReflection\Core\Util\NodeUtil;
class AnonymousFunctionCreationExpressionResolver implements Resolver
{
    public function resolve(NodeContextResolver $resolver, Frame $frame, Node $node) : NodeContext
    {
        \assert($node instanceof AnonymousFunctionCreationExpression);
        $type = NodeUtil::typeFromQualfiedNameLike($resolver->reflector(), $node, $node->returnTypeList);
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
        $type = new ClosureType($resolver->reflector(), $args, $type);
        return NodeContextFactory::create($node->getText(), $node->getStartPosition(), $node->getEndPosition(), ['type' => $type]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\AnonymousFunctionCreationExpressionResolver', 'Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\AnonymousFunctionCreationExpressionResolver', \false);
