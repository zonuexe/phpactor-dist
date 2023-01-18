<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\EnumCaseDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Microsoft\PhpParser\Token;
use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMember;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\ServiceLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionEnumCase as CoreReflectionEnumCase;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\MissingType;
use RuntimeException;
class ReflectionEnumCase extends AbstractReflectionClassMember implements CoreReflectionEnumCase
{
    public function __construct(private ServiceLocator $serviceLocator, private ReflectionEnum $enum, private EnumCaseDeclaration $node)
    {
    }
    public function name() : string
    {
        $name = $this->node->name;
        if ($name instanceof Token) {
            return (string) $name->getText($this->node->getFileContents());
        }
        /** @phpstan-ignore-next-line just in case */
        if ($name instanceof QualifiedName) {
            return $name->__toString();
        }
        throw new RuntimeException('This shoud not happen');
    }
    public function nameRange() : ByteOffsetRange
    {
        $name = $this->node->name;
        return ByteOffsetRange::fromInts($name->getStartPosition(), $name->getEndPosition());
    }
    public function type() : Type
    {
        if ($this->class()->isBacked()) {
            return TypeFactory::enumBackedCaseType($this->class()->type(), $this->name(), $this->value());
        }
        return TypeFactory::enumCaseType($this->serviceLocator()->reflector(), $this->class()->type(), $this->name());
    }
    /**
     * @return ReflectionEnum
     */
    public function class() : ReflectionClassLike
    {
        return $this->enum;
    }
    public function inferredType() : Type
    {
        if (TypeFactory::unknown() !== $this->type()) {
            return $this->type();
        }
        return TypeFactory::undefined();
    }
    public function isVirtual() : bool
    {
        return \false;
    }
    public function value() : Type
    {
        if ($this->node->assignment === null) {
            return new MissingType();
        }
        return $this->serviceLocator()->symbolContextResolver()->resolveNode(new Frame('_'), $this->node->assignment)->type();
    }
    public function memberType() : string
    {
        return ReflectionMember::TYPE_ENUM;
    }
    public function withClass(ReflectionClassLike $class) : ReflectionMember
    {
        if (!$class instanceof ReflectionEnum) {
            throw new RuntimeException('Cannot make case member part of a non-enum reflection');
        }
        return new self($this->serviceLocator, $class, $this->node);
    }
    public function isStatic() : bool
    {
        return \true;
    }
    protected function node() : Node
    {
        return $this->node;
    }
    protected function serviceLocator() : ServiceLocator
    {
        return $this->serviceLocator;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionEnumCase', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionEnumCase', \false);
