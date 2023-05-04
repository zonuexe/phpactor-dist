<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\Trinary;
use Phpactor\WorseReflection\Core\Type;
class IntLiteralType extends \Phpactor\WorseReflection\Core\Type\IntType implements \Phpactor\WorseReflection\Core\Type\Literal, \Phpactor\WorseReflection\Core\Type\Generalizable
{
    use \Phpactor\WorseReflection\Core\Type\LiteralTrait;
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
        return new \Phpactor\WorseReflection\Core\Type\IntType();
    }
    public function identity() : \Phpactor\WorseReflection\Core\Type\NumericType
    {
        return new self(+$this->value());
    }
    public function negative() : \Phpactor\WorseReflection\Core\Type\NumericType
    {
        return new self(-$this->value());
    }
    public function withValue(mixed $value) : \Phpactor\WorseReflection\Core\Type\IntLiteralType
    {
        $new = clone $this;
        $new->value = (int) $value;
        return $new;
    }
    public function accepts(Type $type) : Trinary
    {
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\IntLiteralType) {
            return Trinary::fromBoolean($type->equals($this));
        }
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\IntType) {
            return Trinary::maybe();
        }
        return parent::accepts($type);
    }
}
