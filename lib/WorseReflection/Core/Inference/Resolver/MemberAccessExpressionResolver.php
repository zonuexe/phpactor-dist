<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\MemberAccessExpression;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver\MemberAccess\NodeContextFromMemberAccess;
class MemberAccessExpressionResolver implements Resolver
{
    public function __construct(private NodeContextFromMemberAccess $nodeContextFromMemberAccess)
    {
    }
    public function resolve(NodeContextResolver $resolver, Frame $frame, Node $node) : NodeContext
    {
        \assert($node instanceof MemberAccessExpression);
        $class = $resolver->resolveNode($frame, $node->dereferencableExpression);
        return $this->nodeContextFromMemberAccess->infoFromMemberAccess($resolver, $frame, $class->type(), $node);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\MemberAccessExpressionResolver', 'Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\MemberAccessExpressionResolver', \false);
