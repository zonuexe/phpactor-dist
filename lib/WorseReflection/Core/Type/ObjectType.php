<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\Trinary;
use Phpactor\WorseReflection\Core\Type;
final class ObjectType extends Type
{
    public function __toString() : string
    {
        return 'object';
    }
    public function toPhpString() : string
    {
        return $this->__toString();
    }
    public function accepts(Type $type) : Trinary
    {
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\ParenthesizedType) {
            return $this->accepts($type->type);
        }
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\ClassType) {
            return Trinary::true();
        }
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\ObjectType) {
            return Trinary::true();
        }
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\IntersectionType) {
            return Trinary::true();
        }
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\UnionType) {
            foreach ($type->types as $type) {
                if ($this->accepts($type)->isTrue()) {
                    return Trinary::true();
                }
            }
        }
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\MixedType) {
            return Trinary::maybe();
        }
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\MissingType) {
            return Trinary::maybe();
        }
        return Trinary::false();
    }
}
