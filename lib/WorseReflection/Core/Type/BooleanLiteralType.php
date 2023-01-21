<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\Trinary;
use Phpactor\WorseReflection\Core\Type;
class BooleanLiteralType extends \Phpactor\WorseReflection\Core\Type\BooleanType implements \Phpactor\WorseReflection\Core\Type\Literal, \Phpactor\WorseReflection\Core\Type\Generalizable
{
    use \Phpactor\WorseReflection\Core\Type\LiteralTrait;
    public function __construct(private bool $value)
    {
    }
    public function __toString() : string
    {
        return $this->value ? 'true' : 'false';
    }
    public function value() : bool
    {
        return $this->value;
    }
    public function generalize() : Type
    {
        return new \Phpactor\WorseReflection\Core\Type\BooleanType();
    }
    public function or(\Phpactor\WorseReflection\Core\Type\BooleanType $right) : \Phpactor\WorseReflection\Core\Type\BooleanType
    {
        if ($right instanceof \Phpactor\WorseReflection\Core\Type\BooleanLiteralType) {
            return new self($this->value || $right->value);
        }
        return new \Phpactor\WorseReflection\Core\Type\BooleanType();
    }
    public function and(\Phpactor\WorseReflection\Core\Type\BooleanType $right) : \Phpactor\WorseReflection\Core\Type\BooleanType
    {
        if ($right instanceof \Phpactor\WorseReflection\Core\Type\BooleanLiteralType) {
            return new self($this->value && $right->value);
        }
        return new \Phpactor\WorseReflection\Core\Type\BooleanType();
    }
    public function negate() : \Phpactor\WorseReflection\Core\Type\BooleanType
    {
        return new self(!$this->value);
    }
    public function xor(\Phpactor\WorseReflection\Core\Type\BooleanType $booleanType) : \Phpactor\WorseReflection\Core\Type\BooleanType
    {
        if ($booleanType instanceof \Phpactor\WorseReflection\Core\Type\BooleanLiteralType) {
            return new self($this->value() xor $booleanType->value());
        }
        return new \Phpactor\WorseReflection\Core\Type\BooleanType();
    }
    public function toTrinary() : Trinary
    {
        return Trinary::fromBoolean($this->value);
    }
    public function accepts(Type $type) : Trinary
    {
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\BooleanLiteralType) {
            return Trinary::fromBoolean($type->equals($this));
        }
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\BooleanType) {
            return Trinary::maybe();
        }
        return parent::accepts($type);
    }
}
