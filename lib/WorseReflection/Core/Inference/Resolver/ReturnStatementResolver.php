<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;

use Phpactor202301\Microsoft\PhpParser\Node\Statement\ReturnStatement;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
class ReturnStatementResolver implements Resolver
{
    public function resolve(NodeContextResolver $resolver, Frame $frame, Node $node) : NodeContext
    {
        $context = NodeContextFactory::forNode($node);
        \assert($node instanceof ReturnStatement);
        if (!$node->expression) {
            return $context;
        }
        $type = $resolver->resolveNode($frame, $node->expression)->type();
        $context = $context->withType($type);
        if ($frame->returnType()->isVoid()) {
            $frame->withReturnType($type);
            return $context;
        }
        $frame->withReturnType($frame->returnType()->addType($type));
        return $context;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\ReturnStatementResolver', 'Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\ReturnStatementResolver', \false);
