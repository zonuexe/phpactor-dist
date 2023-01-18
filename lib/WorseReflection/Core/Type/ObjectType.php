<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Trinary;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
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
        if ($type instanceof ParenthesizedType) {
            return $this->accepts($type->type);
        }
        if ($type instanceof ClassType) {
            return Trinary::true();
        }
        if ($type instanceof ObjectType) {
            return Trinary::true();
        }
        if ($type instanceof IntersectionType) {
            return Trinary::true();
        }
        if ($type instanceof UnionType) {
            foreach ($type->types as $type) {
                if ($this->accepts($type)->isTrue()) {
                    return Trinary::true();
                }
            }
        }
        if ($type instanceof MixedType) {
            return Trinary::maybe();
        }
        if ($type instanceof MissingType) {
            return Trinary::maybe();
        }
        return Trinary::false();
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\ObjectType', 'Phpactor\\WorseReflection\\Core\\Type\\ObjectType', \false);
