<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics;

use Generator;
use Phpactor202301\Microsoft\PhpParser\MissingToken;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Expression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\AssignmentExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\MemberAccessExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\Variable;
use Phpactor202301\Microsoft\PhpParser\Token;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\SubscriptExpression;
use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
use Phpactor202301\Phpactor\WorseReflection\Core\DiagnosticProvider;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\NotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClass;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionTrait;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ArrayType;
use Phpactor202301\Phpactor\WorseReflection\Core\Util\NodeUtil;
class AssignmentToMissingPropertyProvider implements DiagnosticProvider
{
    public function exit(NodeContextResolver $resolver, Frame $frame, Node $node) : Generator
    {
        if (!$node instanceof AssignmentExpression) {
            return;
        }
        $memberAccess = $node->leftOperand;
        $accessExpression = null;
        if ($memberAccess instanceof SubscriptExpression) {
            /** @phpstan-ignore-next-line Access expression is NULL if list addition */
            $accessExpression = $memberAccess->accessExpression ?: $memberAccess;
            $memberAccess = $memberAccess->postfixExpression;
        }
        if (!$memberAccess instanceof MemberAccessExpression) {
            return;
        }
        $deref = $memberAccess->dereferencableExpression;
        if (!$deref instanceof Variable) {
            return;
        }
        if ($deref->getText() !== '$this') {
            return;
        }
        $memberNameToken = $memberAccess->memberName;
        if (!$memberNameToken instanceof Token) {
            return;
        }
        $memberName = $memberNameToken->getText($node->getFileContents());
        if (!\is_string($memberName)) {
            return;
        }
        $rightOperand = $node->rightOperand;
        if (!$rightOperand instanceof Expression) {
            return;
        }
        $classNode = NodeUtil::nodeContainerClassLikeDeclaration($node);
        if (null === $classNode) {
            return;
        }
        try {
            $class = $resolver->reflector()->reflectClassLike($classNode->getNamespacedName()->__toString());
        } catch (NotFound) {
            return;
        }
        if (!$class instanceof ReflectionTrait && !$class instanceof ReflectionClass) {
            return;
        }
        if ($class->properties()->has($memberName)) {
            return;
        }
        (yield new AssignmentToMissingPropertyDiagnostic(ByteOffsetRange::fromInts($node->getStartPosition(), $node->getEndPosition()), $class->name()->__toString(), $memberName, $this->resolvePropertyType($resolver, $frame, $rightOperand, $accessExpression), $accessExpression ? \true : \false));
    }
    public function enter(NodeContextResolver $resolver, Frame $frame, Node $node) : iterable
    {
        return [];
    }
    private function resolvePropertyType(NodeContextResolver $resolver, Frame $frame, Expression $rightOperand, Node|MissingToken|null $accessExpression) : Type
    {
        $type = $resolver->resolveNode($frame, $rightOperand)->type();
        if (!$accessExpression instanceof Node) {
            return $type;
        }
        return new ArrayType($accessExpression instanceof SubscriptExpression ? null : $resolver->resolveNode($frame, $accessExpression)->type(), $type);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Diagnostics\\AssignmentToMissingPropertyProvider', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Diagnostics\\AssignmentToMissingPropertyProvider', \false);