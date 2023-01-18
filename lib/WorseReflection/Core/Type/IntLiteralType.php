<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Trinary;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
class IntLiteralType extends IntType implements Literal, Generalizable
{
    use LiteralTrait;
    public function __construct(public int $value)
    {
    }
    public function __toString() : string
    {
        return (string) $this->value;
    }
    public function value() : int
    {
        return $this->value;
    }
    public function generalize() : Type
    {
        return new IntType();
    }
    public function identity() : NumericType
    {
        return new self(+$this->value());
    }
    public function negative() : NumericType
    {
        return new self(-$this->value());
    }
    public function withValue($value) : IntLiteralType
    {
        $new = clone $this;
        $new->value = (int) $value;
        return $new;
    }
    public function accepts(Type $type) : Trinary
    {
        if ($type instanceof IntLiteralType) {
            return Trinary::fromBoolean($type->equals($this));
        }
        if ($type instanceof IntType) {
            return Trinary::maybe();
        }
        return parent::accepts($type);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\IntLiteralType', 'Phpactor\\WorseReflection\\Core\\Type\\IntLiteralType', \false);
