<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Trinary;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
abstract class ScalarType extends PrimitiveType implements Comparable
{
    use ComparableTrait;
    public function __toString() : string
    {
        return $this->toPhpString();
    }
    public function accepts(Type $type) : Trinary
    {
        if ($type->equals($this)) {
            return Trinary::true();
        }
        if ($type instanceof $this) {
            return Trinary::true();
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
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\ScalarType', 'Phpactor\\WorseReflection\\Core\\Type\\ScalarType', \false);
