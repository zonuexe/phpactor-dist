<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\EnumCaseDeclaration;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Symbol;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Util\NodeUtil;
class EnumCaseDeclarationResolver implements Resolver
{
    public function resolve(NodeContextResolver $resolver, Frame $frame, Node $node) : NodeContext
    {
        \assert($node instanceof EnumCaseDeclaration);
        return NodeContextFactory::create(NodeUtil::nameFromTokenOrQualifiedName($node, $node->name), $node->getStartPosition(), $node->getEndPosition(), ['symbol_type' => Symbol::CASE, 'container_type' => NodeUtil::nodeContainerClassLikeType($resolver->reflector(), $node)]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\EnumCaseDeclarationResolver', 'Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\EnumCaseDeclarationResolver', \false);
