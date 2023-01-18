<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection;

use Phpactor202301\Microsoft\PhpParser\Node\Expression\MemberAccessExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ScopedPropertyAccessExpression;
use Phpactor202301\Microsoft\PhpParser\Node\MethodDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\ReturnStatement;
use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\CouldNotResolveNode;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\ItemNotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClass;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionFunctionLike;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMethodCall as CoreReflectionMethodCall;
use Phpactor202301\Phpactor\WorseReflection\Core\Position;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\CallExpression;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionArgumentCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\ServiceLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\MissingType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ReflectedClassType;
use Phpactor202301\Phpactor\WorseReflection\Core\Util\NodeUtil;
use RuntimeException;
abstract class AbstractReflectionMethodCall implements CoreReflectionMethodCall
{
    /**
     * @param ScopedPropertyAccessExpression|MemberAccessExpression $node
     */
    public function __construct(private ServiceLocator $services, private Frame $frame, private Node $node)
    {
    }
    public function position() : Position
    {
        return Position::fromFullStartStartAndEnd($this->node->getFullStartPosition(), $this->node->getStartPosition(), $this->node->getEndPosition());
    }
    public function class() : ReflectionClassLike
    {
        $info = $this->services->symbolContextResolver()->resolveNode($this->frame, $this->node);
        $containerType = $info->containerType();
        if (!$containerType instanceof ReflectedClassType) {
            throw new CouldNotResolveNode(\sprintf('Class for member "%s" could not be determined', $this->name()));
        }
        $reflection = $containerType->reflectionOrNull();
        if (null === $reflection) {
            throw new CouldNotResolveNode(\sprintf('Class for member "%s" could not be determined', $this->name()));
        }
        return $reflection;
    }
    public abstract function isStatic() : bool;
    public function arguments() : ReflectionArgumentCollection
    {
        if (null === $this->callExpression()->argumentExpressionList) {
            return ReflectionArgumentCollection::empty();
        }
        return ReflectionArgumentCollection::fromArgumentListAndFrame($this->services, $this->callExpression()->argumentExpressionList, $this->frame);
    }
    public function name() : string
    {
        return NodeUtil::nameFromTokenOrNode($this->node, $this->node->memberName);
    }
    public function inferredReturnType() : Type
    {
        $return = $this->node->getFirstAncestor(ReturnStatement::class);
        if ($return) {
            $functionLike = $this->functionLike();
            if (null === $functionLike) {
                return new MissingType();
            }
            return $this->class()->scope()->resolveLocalType($functionLike->inferredType());
        }
        return new MissingType();
    }
    public function scope() : ReflectionScope
    {
        return new ReflectionScope($this->services->reflector(), $this->node);
    }
    public function nameRange() : ByteOffsetRange
    {
        $memberName = $this->node->memberName;
        return ByteOffsetRange::fromInts($memberName->getStartPosition(), $memberName->getEndPosition());
    }
    private function callExpression() : CallExpression
    {
        if (!$this->node->parent instanceof CallExpression) {
            throw new RuntimeException('Method call is not a child of a call expression');
        }
        return $this->node->parent;
    }
    private function functionLike() : ?ReflectionFunctionLike
    {
        $method = $this->node->getFirstAncestor(MethodDeclaration::class);
        if ($method instanceof MethodDeclaration) {
            $class = $this->class();
            if ($class instanceof ReflectionClass) {
                try {
                    return $class->methods()->get($method->getName());
                } catch (ItemNotFound) {
                }
            }
        }
        return null;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\AbstractReflectionMethodCall', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\AbstractReflectionMethodCall', \false);