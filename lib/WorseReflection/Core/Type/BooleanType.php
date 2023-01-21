<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\Trinary;
use Phpactor\WorseReflection\Core\Type;
class BooleanType extends \Phpactor\WorseReflection\Core\Type\ScalarType implements \Phpactor\WorseReflection\Core\Type\HasEmptyType
{
    public function toPhpString() : string
    {
        return 'bool';
    }
    public function or(\Phpactor\WorseReflection\Core\Type\BooleanType $right) : \Phpactor\WorseReflection\Core\Type\BooleanType
    {
        return new \Phpactor\WorseReflection\Core\Type\BooleanType();
    }
    public function and(\Phpactor\WorseReflection\Core\Type\BooleanType $booleanType) : \Phpactor\WorseReflection\Core\Type\BooleanType
    {
        return new \Phpactor\WorseReflection\Core\Type\BooleanType();
    }
    public function negate() : \Phpactor\WorseReflection\Core\Type\BooleanType
    {
        return new \Phpactor\WorseReflection\Core\Type\BooleanType();
    }
    public function xor(\Phpactor\WorseReflection\Core\Type\BooleanType $booleanType) : \Phpactor\WorseReflection\Core\Type\BooleanType
    {
        return new \Phpactor\WorseReflection\Core\Type\BooleanType();
    }
    public function toTrinary() : Trinary
    {
        return Trinary::maybe();
    }
    public function isTrue() : bool
    {
        if ($this instanceof \Phpactor\WorseReflection\Core\Type\BooleanLiteralType) {
            return $this->value() === \true;
        }
        return \false;
    }
    public function emptyType() : Type
    {
        return new \Phpactor\WorseReflection\Core\Type\BooleanLiteralType(\false);
    }
}
