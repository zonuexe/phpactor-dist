<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\Type;
class IntType extends \Phpactor\WorseReflection\Core\Type\NumericType implements \Phpactor\WorseReflection\Core\Type\BitwiseOperable, \Phpactor\WorseReflection\Core\Type\HasEmptyType
{
    public function toPhpString() : string
    {
        return 'int';
    }
    public function shiftRight(Type $right) : Type
    {
        if ($right instanceof \Phpactor\WorseReflection\Core\Type\IntType && $right instanceof \Phpactor\WorseReflection\Core\Type\Literal && $this instanceof \Phpactor\WorseReflection\Core\Type\Literal) {
            return $this->withValue($this->value() >> $right->value());
        }
        return new \Phpactor\WorseReflection\Core\Type\BooleanType();
    }
    public function shiftLeft(Type $right) : Type
    {
        if ($right instanceof \Phpactor\WorseReflection\Core\Type\IntType && $right instanceof \Phpactor\WorseReflection\Core\Type\Literal && $this instanceof \Phpactor\WorseReflection\Core\Type\Literal) {
            return $this->withValue($this->value() << $right->value());
        }
        return new \Phpactor\WorseReflection\Core\Type\BooleanType();
    }
    public function bitwiseXor(Type $right) : Type
    {
        if ($right instanceof \Phpactor\WorseReflection\Core\Type\IntType && $right instanceof \Phpactor\WorseReflection\Core\Type\Literal && $this instanceof \Phpactor\WorseReflection\Core\Type\Literal) {
            return $this->withValue($this->value() ^ $right->value());
        }
        return new \Phpactor\WorseReflection\Core\Type\BooleanType();
    }
    public function bitwiseOr(Type $right) : Type
    {
        if ($right instanceof \Phpactor\WorseReflection\Core\Type\IntType && $right instanceof \Phpactor\WorseReflection\Core\Type\Literal && $this instanceof \Phpactor\WorseReflection\Core\Type\Literal) {
            return $this->withValue($this->value() | $right->value());
        }
        return new \Phpactor\WorseReflection\Core\Type\BooleanType();
    }
    public function bitwiseAnd(Type $right) : Type
    {
        if ($right instanceof \Phpactor\WorseReflection\Core\Type\IntType && $right instanceof \Phpactor\WorseReflection\Core\Type\Literal && $this instanceof \Phpactor\WorseReflection\Core\Type\Literal) {
            return $this->withValue($this->value() & $right->value());
        }
        return new \Phpactor\WorseReflection\Core\Type\BooleanType();
    }
    public function bitwiseNot() : Type
    {
        if ($this instanceof \Phpactor\WorseReflection\Core\Type\Literal) {
            return $this->withValue(~(int) $this->value());
        }
        return $this;
    }
    public function emptyType() : Type
    {
        return new \Phpactor\WorseReflection\Core\Type\IntLiteralType(0);
    }
}
