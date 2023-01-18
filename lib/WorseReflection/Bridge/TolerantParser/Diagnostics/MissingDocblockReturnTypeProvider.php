<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\MethodDeclaration;
use Phpactor202301\Phpactor\WorseReflection\Core\DiagnosticProvider;
use Phpactor202301\Phpactor\WorseReflection\Core\DiagnosticSeverity;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\NotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\GenericClassType;
use Phpactor202301\Phpactor\WorseReflection\Core\Util\NodeUtil;
class MissingDocblockReturnTypeProvider implements DiagnosticProvider
{
    public function exit(NodeContextResolver $resolver, Frame $frame, Node $node) : iterable
    {
        if (!$node instanceof MethodDeclaration) {
            return;
        }
        $declaration = NodeUtil::nodeContainerClassLikeDeclaration($node);
        if (null === $declaration) {
            return;
        }
        try {
            $class = $resolver->reflector()->reflectClassLike($declaration->getNamespacedName()->__toString());
            $methodName = $node->name->getText($node->getFileContents());
            if (!\is_string($methodName)) {
                return;
            }
            $method = $class->methods()->get($methodName);
        } catch (NotFound) {
            return;
        }
        $docblock = $method->docblock();
        $docblockType = $docblock->returnType();
        $actualReturnType = $frame->returnType()->generalize();
        $claimedReturnType = $method->inferredType();
        $phpReturnType = $method->type();
        // if there is already a return type, ignore. phpactor's guess
        // will currently likely be wrong often.
        if ($method->docblock()->returnType()->isDefined()) {
            return;
        }
        // do not try it for overriden methods
        if ($method->original()->declaringClass()->name() != $class->name()) {
            return;
        }
        if ($method->name() === '__construct') {
            return;
        }
        // it's void
        if (\false === $actualReturnType->isDefined()) {
            return;
        }
        if ($claimedReturnType->isDefined() && !$claimedReturnType->isClass() && !$claimedReturnType->isArray() && !$claimedReturnType->isClosure()) {
            return;
        }
        if ($actualReturnType->isClosure()) {
            (yield new MissingDocblockReturnTypeDiagnostic($method->nameRange(), \sprintf('Method "%s" is missing docblock return type: %s', $methodName, $actualReturnType->__toString()), DiagnosticSeverity::WARNING(), $class->name()->__toString(), $methodName, $actualReturnType->__toString()));
            return;
        }
        if ($claimedReturnType->isClass() && !$actualReturnType instanceof GenericClassType) {
            return;
        }
        if ($claimedReturnType->isArray() && $actualReturnType->isMixed()) {
            return;
        }
        // the docblock matches the generalized return type
        // it's OK
        if ($claimedReturnType->equals($actualReturnType)) {
            return;
        }
        (yield new MissingDocblockReturnTypeDiagnostic($method->nameRange(), \sprintf('Method "%s" is missing docblock return type: %s', $methodName, $actualReturnType->__toString()), DiagnosticSeverity::WARNING(), $class->name()->__toString(), $methodName, $actualReturnType->__toString()));
    }
    public function enter(NodeContextResolver $resolver, Frame $frame, Node $node) : iterable
    {
        return [];
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Diagnostics\\MissingDocblockReturnTypeProvider', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Diagnostics\\MissingDocblockReturnTypeProvider', \false);
