<?php

namespace Phpactor\WorseReflection\Core\Inference\Resolver;

use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\ParenthesizedExpression;
use Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor\WorseReflection\Core\Inference\Resolver;
use Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
class ParenthesizedExpressionResolver implements Resolver
{
    public function resolve(NodeContextResolver $resolver, Frame $frame, Node $node) : NodeContext
    {
        \assert($node instanceof ParenthesizedExpression);
        return $resolver->resolveNode($frame, $node->expression);
    }
}
