<?php

namespace Phpactor\WorseReflection\Core;

use Closure;
use Phpactor\WorseReflection\Core\Reflection\ReflectionScope;
use Phpactor\WorseReflection\Core\Type\AggregateType;
use Phpactor\WorseReflection\Core\Type\ArrayType;
use Phpactor\WorseReflection\Core\Type\ClassType;
use Phpactor\WorseReflection\Core\Type\ClosureType;
use Phpactor\WorseReflection\Core\Type\Generalizable;
use Phpactor\WorseReflection\Core\Type\GenericClassType;
use Phpactor\WorseReflection\Core\Type\IntersectionType;
use Phpactor\WorseReflection\Core\Type\Literal;
use Phpactor\WorseReflection\Core\Type\MissingType;
use Phpactor\WorseReflection\Core\Type\MixedType;
use Phpactor\WorseReflection\Core\Type\NullableType;
use Phpactor\WorseReflection\Core\Type\PrimitiveType;
use Phpactor\WorseReflection\Core\Type\UnionType;
use Phpactor\WorseReflection\Core\Type\VoidType;
abstract class Type
{
    public abstract function __toString() : string;
    public abstract function toPhpString() : string;
    /**
     * As in a parameter can accept an argument.
     *
     * - string         < string
     * - string|null    < null || string
     * - "hello"|string < hello || string
     * - string         < "hello" or any string literal (which narrow the string type)
     * - "hello"        < does not accept string
     * - ""             - does not accept string
     */
    public abstract function accepts(\Phpactor\WorseReflection\Core\Type $type) : \Phpactor\WorseReflection\Core\Trinary;
    /**
     * Return a collection of first-class types.
     *
     * If this type is an aggregate this method will
     * return a collection types of that aggregate or intersection type.
     *
     * @return Types<Type>
     */
    public function expandTypes() : \Phpactor\WorseReflection\Core\Types
    {
        /** @phpstan-ignore-next-line */
        return new \Phpactor\WorseReflection\Core\Types([$this]);
    }
    /**
     * Return ALL types referenced in this type.
     *
     * For example:
     *
     * - `MyGeneric<One,string,int>`: Will Return `MyGeneric`, `One`, `string` and `int`.
     * - `MyClass`: Will return `MyClass`.
     * - `Closure(Foobar,int): float`: Will return `Closure` (as a "class" type), `Foobar`, `int` and `float` `
     * @return Types<Type>
     */
    public function allTypes() : \Phpactor\WorseReflection\Core\Types
    {
        /** @phpstan-ignore-next-line */
        return new \Phpactor\WorseReflection\Core\Types([$this]);
    }
    public function isDefined() : bool
    {
        return !$this instanceof MissingType;
    }
    public function isVoid() : bool
    {
        return $this instanceof VoidType;
    }
    public function isClass() : bool
    {
        return $this instanceof ClassType;
    }
    public function isClosure() : bool
    {
        return $this instanceof ClosureType;
    }
    public function isArray() : bool
    {
        return $this instanceof ArrayType;
    }
    public function isNullable() : bool
    {
        return \false;
    }
    public function addType(\Phpactor\WorseReflection\Core\Type $type) : AggregateType
    {
        return new UnionType($this, $type);
    }
    public function isPrimitive() : bool
    {
        return $this instanceof PrimitiveType;
    }
    public function short() : string
    {
        $type = $this;
        if ($type instanceof AggregateType) {
            // generalize literal types in order to de-duplicate them
            $type = $type->generalize()->reduce();
        }
        if ($type instanceof UnionType) {
            return \implode('|', \array_map(fn(\Phpactor\WorseReflection\Core\Type $t) => $t->short(), $type->types));
        }
        if ($type instanceof IntersectionType) {
            return \implode('&', \array_map(fn(\Phpactor\WorseReflection\Core\Type $t) => $t->short(), $type->types));
        }
        if ($type instanceof NullableType) {
            return '?' . $type->type->short();
        }
        if ($type instanceof GenericClassType) {
            return \sprintf('%s<%s>', $type->name()->short(), \implode(',', \array_map(fn(\Phpactor\WorseReflection\Core\Type $arg) => $arg->short(), $type->arguments())));
        }
        if ($type instanceof ClassType) {
            return $type->name()->short();
        }
        return $type->toPhpString();
    }
    /**
     * @returnc self
     */
    public function toLocalType(ReflectionScope $scope) : self
    {
        // TODO: do not modify type by reference
        return $this->map(fn(\Phpactor\WorseReflection\Core\Type $type) => $scope->resolveLocalType(clone $type));
    }
    public static function fromTypes(\Phpactor\WorseReflection\Core\Type ...$types) : \Phpactor\WorseReflection\Core\Type
    {
        if (\count($types) === 0) {
            return new MissingType();
        }
        if (\count($types) === 1) {
            return $types[0];
        }
        return new UnionType(...$types);
    }
    public function generalize() : \Phpactor\WorseReflection\Core\Type
    {
        return $this->map(function (\Phpactor\WorseReflection\Core\Type $type) {
            return $type instanceof Generalizable ? $type->generalize() : $type;
        });
    }
    public function equals(\Phpactor\WorseReflection\Core\Type $type) : bool
    {
        return $this->__toString() === $type->__toString();
    }
    public function instanceof(\Phpactor\WorseReflection\Core\Type $type) : \Phpactor\WorseReflection\Core\Trinary
    {
        return \Phpactor\WorseReflection\Core\Trinary::fromBoolean($type->equals($this));
    }
    public function isNull() : bool
    {
        return \false;
    }
    public function stripNullable() : \Phpactor\WorseReflection\Core\Type
    {
        return $this;
    }
    public function reduce() : \Phpactor\WorseReflection\Core\Type
    {
        return $this;
    }
    public function isTrue() : bool
    {
        return \false;
    }
    public function isEmpty() : \Phpactor\WorseReflection\Core\Trinary
    {
        $empty = \Phpactor\WorseReflection\Core\TypeFactory::unionEmpty()->accepts($this);
        if ($empty->isTrue() || $empty->isFalse()) {
            return $empty;
        }
        if ($this instanceof Literal) {
            return \Phpactor\WorseReflection\Core\Trinary::false();
        }
        return \Phpactor\WorseReflection\Core\Trinary::maybe();
    }
    public function isMixed() : bool
    {
        return $this instanceof MixedType;
    }
    public function mergeType(\Phpactor\WorseReflection\Core\Type $type) : \Phpactor\WorseReflection\Core\Type
    {
        if ($this instanceof MissingType) {
            return $type;
        }
        if ($this instanceof AggregateType) {
            return $this->add($type);
        }
        return \Phpactor\WorseReflection\Core\TypeFactory::intersection($this, $type);
    }
    /**
     * @param Closure(Type): Type $mapper
     */
    public function map(Closure $mapper) : \Phpactor\WorseReflection\Core\Type
    {
        return $mapper($this);
    }
    /**
     * If this type can "consume" or replace the given type
     */
    public function consumes(\Phpactor\WorseReflection\Core\Type $type2) : \Phpactor\WorseReflection\Core\Trinary
    {
        return \Phpactor\WorseReflection\Core\Trinary::maybe();
    }
    /**
     * If the type has been augmented with more information
     * than a standard PHP type (e.g. typed arrays, generics, closures, etc).
     *
     * For example augmented types should have a php doc.
     */
    public function isAugmented() : bool
    {
        return $this->isDefined() && !$this->isPrimitive() && $this->__toString() !== $this->toPhpString();
    }
}
