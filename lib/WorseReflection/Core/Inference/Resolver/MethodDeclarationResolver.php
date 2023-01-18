<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\MethodDeclaration;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Context\MemberDeclarationContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Symbol;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Position;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Util\NodeUtil;
class MethodDeclarationResolver implements Resolver
{
    public function resolve(NodeContextResolver $resolver, Frame $frame, Node $node) : NodeContext
    {
        \assert($node instanceof MethodDeclaration);
        $classNode = NodeUtil::nodeContainerClassLikeDeclaration($node);
        $classSymbolContext = $resolver->resolveNode($frame, $classNode);
        return new MemberDeclarationContext(Symbol::fromTypeNameAndPosition(Symbol::METHOD, (string) $node->name->getText($node->getFileContents()), Position::fromStartAndEnd($node->name->getStartPosition(), $node->name->getEndPosition())), TypeFactory::unknown(), $classSymbolContext->type());
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\MethodDeclarationResolver', 'Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\MethodDeclarationResolver', \false);
