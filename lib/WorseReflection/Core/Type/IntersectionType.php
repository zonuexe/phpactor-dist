<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\Trinary;
use Phpactor\WorseReflection\Core\Type;
use Phpactor\WorseReflection\Core\TypeFactory;
final class IntersectionType extends \Phpactor\WorseReflection\Core\Type\AggregateType
{
    public function __toString() : string
    {
        return \implode('&', \array_map(fn(Type $type) => $type->__toString(), $this->types));
    }
    public static function toIntersection(Type $type) : \Phpactor\WorseReflection\Core\Type\AggregateType
    {
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\NullableType) {
            return self::toIntersection($type->type)->add(TypeFactory::null());
        }
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\IntersectionType) {
            return $type;
        }
        return new \Phpactor\WorseReflection\Core\Type\IntersectionType($type);
    }
    public static function fromTypes(Type ...$types) : Type
    {
        if (\count($types) === 0) {
            return new \Phpactor\WorseReflection\Core\Type\MissingType();
        }
        if (\count($types) === 1) {
            return $types[0];
        }
        return new \Phpactor\WorseReflection\Core\Type\IntersectionType(...$types);
    }
    public function short() : string
    {
        return \implode('&', \array_map(fn(Type $t) => $t->short(), $this->types));
    }
    public function withTypes(Type ...$types) : \Phpactor\WorseReflection\Core\Type\AggregateType
    {
        return new self(...$types);
    }
    public function toPhpString() : string
    {
        return \implode('&', \array_map(fn(Type $type) => $type->toPhpString(), $this->types));
    }
    public function accepts(Type $type) : Trinary
    {
        if (!$type instanceof \Phpactor\WorseReflection\Core\Type\ClassType && !$type instanceof \Phpactor\WorseReflection\Core\Type\IntersectionType) {
            return Trinary::false();
        }
        if ($type->equals($this)) {
            return Trinary::true();
        }
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\ReflectedClassType) {
            foreach ($this->types as $type) {
                if ($type->instanceof($type)->isFalse()) {
                    return Trinary::false();
                }
            }
            return Trinary::true();
        }
        return Trinary::false();
    }
}
