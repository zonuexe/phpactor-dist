<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ScopedPropertyAccessExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\Variable;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeToTypeConverter;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver\MemberAccess\NodeContextFromMemberAccess;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ClassType;
class ScopedPropertyAccessResolver implements Resolver
{
    public function __construct(private NodeToTypeConverter $nodeTypeConverter, private NodeContextFromMemberAccess $nodeContextFromMemberAccess)
    {
    }
    public function resolve(NodeContextResolver $resolver, Frame $frame, Node $node) : NodeContext
    {
        \assert($node instanceof ScopedPropertyAccessExpression);
        $name = null;
        if ($node->scopeResolutionQualifier instanceof Variable) {
            $context = $resolver->resolveNode($frame, $node->scopeResolutionQualifier);
            $type = $context->type();
            if ($type instanceof ClassType) {
                $name = $type->name->__toString();
            }
        }
        if (empty($name)) {
            $name = $node->scopeResolutionQualifier->getText();
        }
        $classType = $this->nodeTypeConverter->resolve($node, (string) $name);
        return $this->nodeContextFromMemberAccess->infoFromMemberAccess($resolver, $frame, $classType, $node);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\ScopedPropertyAccessResolver', 'Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\ScopedPropertyAccessResolver', \false);
