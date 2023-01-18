<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\ReservedWord;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Symbol;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Util\NodeUtil;
class ReservedWordResolver implements Resolver
{
    public function resolve(NodeContextResolver $resolver, Frame $frame, Node $node) : NodeContext
    {
        \assert($node instanceof ReservedWord);
        $symbolType = $containerType = $type = $value = null;
        $word = \strtolower($node->getText());
        if ('null' === $word) {
            $type = TypeFactory::null();
            $symbolType = Symbol::UNKNOWN;
            $containerType = NodeUtil::nodeContainerClassLikeType($resolver->reflector(), $node);
        }
        if ('false' === $word) {
            $value = \false;
            $type = TypeFactory::boolLiteral($value);
            $symbolType = Symbol::BOOLEAN;
            $containerType = NodeUtil::nodeContainerClassLikeType($resolver->reflector(), $node);
        }
        if ('true' === $word) {
            $value = \true;
            $type = TypeFactory::boolLiteral($value);
            $symbolType = Symbol::BOOLEAN;
            $containerType = NodeUtil::nodeContainerClassLikeType($resolver->reflector(), $node);
        }
        $info = NodeContextFactory::create($node->getText(), $node->getStartPosition(), $node->getEndPosition(), ['type' => $type, 'symbol_type' => $symbolType === null ? Symbol::UNKNOWN : $symbolType, 'container_type' => $containerType]);
        if (null === $symbolType) {
            $info = $info->withIssue(\sprintf('Could not resolve reserved word "%s"', $node->getText()));
        }
        if (null === $type) {
            $info = $info->withIssue(\sprintf('Could not resolve reserved word "%s"', $node->getText()));
        }
        return $info;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\ReservedWordResolver', 'Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\ReservedWordResolver', \false);
