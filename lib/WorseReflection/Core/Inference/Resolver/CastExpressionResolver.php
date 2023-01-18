<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\CastExpression;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Util\NodeUtil;
class CastExpressionResolver implements Resolver
{
    public function resolve(NodeContextResolver $resolver, Frame $frame, Node $node) : NodeContext
    {
        \assert($node instanceof CastExpression);
        $type = NodeUtil::nameFromTokenOrNode($node, $node->castType);
        $type = \rtrim(\ltrim($type, '('), ')');
        $type = TypeFactory::fromStringWithReflector($type, $resolver->reflector());
        $context = NodeContextFactory::create('cast', $node->getStartPosition(), $node->getEndPosition(), ['type' => $type]);
        if (!\in_array($type->__toString(), ['string', 'bool', 'float', 'string', 'array', 'object', 'integer', 'boolean', 'double'])) {
            $context = $context->withIssue(\sprintf('Unsupported cast "%s"', $type->__toString()));
        }
        return $context;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\CastExpressionResolver', 'Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\CastExpressionResolver', \false);
