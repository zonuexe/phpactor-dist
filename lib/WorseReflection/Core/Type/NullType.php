<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\Trinary;
use Phpactor\WorseReflection\Core\Type;
final class NullType extends \Phpactor\WorseReflection\Core\Type\PrimitiveType implements \Phpactor\WorseReflection\Core\Type\HasEmptyType
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
        return Trinary::fromBoolean($type instanceof \Phpactor\WorseReflection\Core\Type\MixedType || $type instanceof \Phpactor\WorseReflection\Core\Type\NullType);
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
