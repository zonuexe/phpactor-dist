<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\Trinary;
use Phpactor\WorseReflection\Core\Type;
abstract class ScalarType extends \Phpactor\WorseReflection\Core\Type\PrimitiveType implements \Phpactor\WorseReflection\Core\Type\Comparable
{
    use \Phpactor\WorseReflection\Core\Type\ComparableTrait;
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
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\MixedType) {
            return Trinary::maybe();
        }
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\MissingType) {
            return Trinary::maybe();
        }
        return Trinary::false();
    }
}
