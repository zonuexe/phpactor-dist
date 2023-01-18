<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\NumericLiteral;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Symbol;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\Literal;
use Phpactor202301\Phpactor\WorseReflection\Core\Util\NodeUtil;
class NumericLiteralResolver implements Resolver
{
    public function resolve(NodeContextResolver $resolver, Frame $frame, Node $node) : NodeContext
    {
        \assert($node instanceof NumericLiteral);
        $type = TypeFactory::fromNumericString($node->getText());
        \assert($type instanceof Literal);
        return NodeContextFactory::create($node->getText(), $node->getStartPosition(), $node->getEndPosition(), ['symbol_type' => Symbol::NUMBER, 'type' => $type, 'container_type' => NodeUtil::nodeContainerClassLikeType($resolver->reflector(), $node)]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\NumericLiteralResolver', 'Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\NumericLiteralResolver', \false);
