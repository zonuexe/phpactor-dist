<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Trinary;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
final class NullType extends PrimitiveType implements HasEmptyType
{
    public function __toString() : string
    {
        return 'null';
    }
    public function toPhpString() : string
    {
        return 'null';
    }
    public function accepts(Type $type) : Trinary
    {
        return Trinary::fromBoolean($type instanceof MixedType || $type instanceof NullType);
    }
    public function isNull() : bool
    {
        return \true;
    }
    public function emptyType() : Type
    {
        return $this;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\NullType', 'Phpactor\\WorseReflection\\Core\\Type\\NullType', \false);
