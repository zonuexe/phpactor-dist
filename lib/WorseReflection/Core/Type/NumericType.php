<?php

namespace Phpactor\WorseReflection\Core\Type;

abstract class NumericType extends \Phpactor\WorseReflection\Core\Type\ScalarType
{
    public function identity() : \Phpactor\WorseReflection\Core\Type\NumericType
    {
        return $this;
    }
    public function negative() : \Phpactor\WorseReflection\Core\Type\NumericType
    {
        return $this;
    }
    public function plus(\Phpactor\WorseReflection\Core\Type\NumericType $right) : \Phpactor\WorseReflection\Core\Type\NumericType
    {
        if ($this instanceof \Phpactor\WorseReflection\Core\Type\Literal && $right instanceof \Phpactor\WorseReflection\Core\Type\Literal) {
            return $this->withValue($this->value() + $right->value());
        }
        return $this;
    }
    public function modulo(\Phpactor\WorseReflection\Core\Type\NumericType $right) : \Phpactor\WorseReflection\Core\Type\NumericType
    {
        if ($this instanceof \Phpactor\WorseReflection\Core\Type\Literal && $right instanceof \Phpactor\WorseReflection\Core\Type\Literal) {
            return $this->withValue($this->value() % $right->value());
        }
        return $this;
    }
    public function divide(\Phpactor\WorseReflection\Core\Type\NumericType $right) : \Phpactor\WorseReflection\Core\Type\NumericType
    {
        if ($this instanceof \Phpactor\WorseReflection\Core\Type\Literal && $right instanceof \Phpactor\WorseReflection\Core\Type\Literal) {
            return $this->withValue($this->value() / $right->value());
        }
        return $this;
    }
    public function multiply(\Phpactor\WorseReflection\Core\Type\NumericType $right) : \Phpactor\WorseReflection\Core\Type\NumericType
    {
        if ($this instanceof \Phpactor\WorseReflection\Core\Type\Literal && $right instanceof \Phpactor\WorseReflection\Core\Type\Literal) {
            return $this->withValue($this->value() * $right->value());
        }
        return $this;
    }
    public function minus(\Phpactor\WorseReflection\Core\Type\NumericType $right) : \Phpactor\WorseReflection\Core\Type\NumericType
    {
        if ($this instanceof \Phpactor\WorseReflection\Core\Type\Literal && $right instanceof \Phpactor\WorseReflection\Core\Type\Literal) {
            return $this->withValue($this->value() - $right->value());
        }
        return $this;
    }
    public function exp(\Phpactor\WorseReflection\Core\Type\NumericType $right) : \Phpactor\WorseReflection\Core\Type\NumericType
    {
        if ($this instanceof \Phpactor\WorseReflection\Core\Type\Literal && $right instanceof \Phpactor\WorseReflection\Core\Type\Literal) {
            return $this->withValue($this->value() ** $right->value());
        }
        return $this;
    }
}
