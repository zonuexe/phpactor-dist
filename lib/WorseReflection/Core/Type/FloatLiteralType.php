<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\Trinary;
use Phpactor\WorseReflection\Core\Type;
final class FloatLiteralType extends \Phpactor\WorseReflection\Core\Type\FloatType implements \Phpactor\WorseReflection\Core\Type\Literal, \Phpactor\WorseReflection\Core\Type\Generalizable
{
    use \Phpactor\WorseReflection\Core\Type\LiteralTrait;
    public function __construct(public float $value)
    {
    }
    public function __toString() : string
    {
        return (string) $this->value;
    }
    public function value() : float
    {
        return $this->value;
    }
    public function generalize() : Type
    {
        return new \Phpactor\WorseReflection\Core\Type\FloatType();
    }
    public function identity() : \Phpactor\WorseReflection\Core\Type\NumericType
    {
        return new self(+$this->value());
    }
    public function negative() : \Phpactor\WorseReflection\Core\Type\NumericType
    {
        return new self(-$this->value());
    }
    public function withValue($value) : self
    {
        $new = clone $this;
        $new->value = $value;
        return $new;
    }
    public function accepts(Type $type) : Trinary
    {
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\FloatLiteralType) {
            return Trinary::fromBoolean($type->equals($this));
        }
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\FloatType) {
            return Trinary::maybe();
        }
        return parent::accepts($type);
    }
}
