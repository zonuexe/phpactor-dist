<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\CallExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\MemberAccessExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ScopedPropertyAccessExpression;
use Phpactor202301\Microsoft\PhpParser\Token;
use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
use Phpactor202301\Phpactor\WorseReflection\Core\DiagnosticProvider;
use Phpactor202301\Phpactor\WorseReflection\Core\DiagnosticSeverity;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\NotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMember;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ReflectedClassType;
class MissingMethodProvider implements DiagnosticProvider
{
    public function exit(NodeContextResolver $resolver, Frame $frame, Node $node) : iterable
    {
        if (!$node instanceof CallExpression) {
            return;
        }
        $memberName = null;
        if ($node->callableExpression instanceof MemberAccessExpression) {
            $memberName = $node->callableExpression->memberName;
        } elseif ($node->callableExpression instanceof ScopedPropertyAccessExpression) {
            $memberName = $node->callableExpression->memberName;
        }
        if (!$memberName instanceof Token) {
            return;
        }
        $containerType = $resolver->resolveNode($frame, $node)->containerType();
        if (!$containerType->isDefined()) {
            return;
        }
        if (!$containerType instanceof ReflectedClassType) {
            return;
        }
        $methodName = $memberName->getText($node->getFileContents());
        if (!\is_string($methodName)) {
            return;
        }
        try {
            $name = $containerType->members()->byMemberType(ReflectionMember::TYPE_METHOD)->get($methodName);
        } catch (NotFound) {
            (yield new MissingMethodDiagnostic(ByteOffsetRange::fromInts($memberName->getStartPosition(), $memberName->getEndPosition()), \sprintf('Method "%s" does not exist on class "%s"', $methodName, $containerType->__toString()), DiagnosticSeverity::ERROR(), $containerType->name()->__toString(), $methodName));
        }
    }
    public function enter(NodeContextResolver $resolver, Frame $frame, Node $node) : iterable
    {
        return [];
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Diagnostics\\MissingMethodProvider', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Diagnostics\\MissingMethodProvider', \false);
