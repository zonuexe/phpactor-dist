<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\ClassName;
use Phpactor\WorseReflection\Core\Exception\NotFound;
use Phpactor\WorseReflection\Core\Reflection\Collection\ClassLikeReflectionMemberCollection;
use Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection;
use Phpactor\WorseReflection\Core\Reflection\ReflectionClass;
use Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
use Phpactor\WorseReflection\Core\Reflection\ReflectionInterface;
use Phpactor\WorseReflection\Core\Reflection\ReflectionMember;
use Phpactor\WorseReflection\Core\Reflector\ClassReflector;
use Phpactor\WorseReflection\Core\Trinary;
use Phpactor\WorseReflection\Core\Type;
use Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor\WorseReflection\Core\Type\Resolver\IterableTypeResolver;
class ReflectedClassType extends \Phpactor\WorseReflection\Core\Type\ClassType
{
    public function __construct(protected ClassReflector $reflector, public ClassName $name)
    {
        $this->members = ClassLikeReflectionMemberCollection::empty();
    }
    public function __toString() : string
    {
        return $this->name->full();
    }
    public function toPhpString() : string
    {
        return $this->__toString();
    }
    /**
     * @return ReflectionMemberCollection<ReflectionMember>
     */
    public function members() : ReflectionMemberCollection
    {
        $reflection = $this->reflectionOrNull();
        if (null === $reflection) {
            return $this->members;
        }
        return $this->members->merge($reflection->members());
    }
    public function isInvokable() : bool
    {
        $reflection = $this->reflectionOrNull();
        if (null === $reflection) {
            return \false;
        }
        return $reflection->methods()->has('__invoke');
    }
    /**
     * Accept if same class or class extends this class
     */
    public function accepts(Type $type) : Trinary
    {
        if ($type->equals($this)) {
            return Trinary::true();
        }
        if (!$type instanceof \Phpactor\WorseReflection\Core\Type\ClassType) {
            return Trinary::false();
        }
        $reflectedThis = $this->reflectionOrNull();
        if (null === $reflectedThis) {
            return Trinary::maybe();
        }
        try {
            $reflectedThat = $this->reflector->reflectClassLike($type->name());
        } catch (NotFound) {
            return Trinary::maybe();
        }
        if ($reflectedThis instanceof ReflectionInterface) {
            return Trinary::fromBoolean($reflectedThat->isInstanceOf($reflectedThis->name()));
        }
        if ($reflectedThat->name() == $this->name()) {
            return Trinary::true();
        }
        if ($reflectedThat instanceof ReflectionClass) {
            while ($parent = $reflectedThat->parent()) {
                if ($parent->name() == $this->name()) {
                    return Trinary::true();
                }
                $reflectedThat = $parent;
            }
        }
        return Trinary::false();
    }
    public function reflectionOrNull() : ?ReflectionClassLike
    {
        try {
            return $this->reflector->reflectClassLike($this->name());
        } catch (NotFound) {
        }
        return null;
    }
    public function iterableValueType() : Type
    {
        $class = $this->reflectionOrNull();
        if (!$class instanceof ReflectionClassLike) {
            return new \Phpactor\WorseReflection\Core\Type\MissingType();
        }
        $scope = $class->scope();
        \assert($class instanceof ReflectionClassLike);
        $genericTypes = \array_merge($class->docblock()->implements(), $class->docblock()->extends());
        foreach ($genericTypes as $genericType) {
            if (!$genericType instanceof \Phpactor\WorseReflection\Core\Type\GenericClassType) {
                continue;
            }
            $type = IterableTypeResolver::resolveIterable($this->reflector, $genericType, $genericType->arguments());
            if (!$type->isDefined()) {
                continue;
            }
            return $type;
        }
        return new \Phpactor\WorseReflection\Core\Type\MissingType();
    }
    public function instanceof(Type $type) : Trinary
    {
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\MissingType) {
            return Trinary::maybe();
        }
        if (!$type instanceof \Phpactor\WorseReflection\Core\Type\StringType && !$type instanceof \Phpactor\WorseReflection\Core\Type\ClassType) {
            return Trinary::false();
        }
        $reflection = $this->reflectionOrNull();
        if (!$reflection) {
            return Trinary::maybe();
        }
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\StringLiteralType) {
            return Trinary::fromBoolean($reflection->isInstanceOf(ClassName::fromString($type->value())));
        }
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\ClassType) {
            return Trinary::fromBoolean($reflection->isInstanceOf($type->name()));
        }
        return Trinary::maybe();
    }
    /**
     * If the class type has a template, then upcast it
     */
    public function upcastToGeneric() : \Phpactor\WorseReflection\Core\Type\ReflectedClassType
    {
        if ($this instanceof \Phpactor\WorseReflection\Core\Type\GenericClassType) {
            return $this;
        }
        $reflection = $this->reflectionOrNull();
        if (!$reflection) {
            return $this;
        }
        if (0 === $reflection->templateMap()->count()) {
            return $this;
        }
        return new \Phpactor\WorseReflection\Core\Type\GenericClassType($this->reflector, $this->name(), $reflection->templateMap()->toArray());
    }
    public function isInterface() : Trinary
    {
        $reflection = $this->reflectionOrNull();
        if (null === $reflection) {
            return Trinary::maybe();
        }
        return Trinary::fromBoolean($reflection instanceof ReflectionInterface);
    }
    public function invokeType() : Type
    {
        $reflection = $this->reflectionOrNull();
        if (null === $reflection) {
            return TypeFactory::undefined();
        }
        try {
            return $reflection->methods()->get('__invoke')->inferredType();
        } catch (NotFound) {
            return TypeFactory::undefined();
        }
    }
}
