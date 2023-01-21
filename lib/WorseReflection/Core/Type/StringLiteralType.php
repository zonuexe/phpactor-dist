<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\Trinary;
use Phpactor\WorseReflection\Core\Type;
class StringLiteralType extends \Phpactor\WorseReflection\Core\Type\StringType implements \Phpactor\WorseReflection\Core\Type\Literal, \Phpactor\WorseReflection\Core\Type\Generalizable, \Phpactor\WorseReflection\Core\Type\Concatable
{
    use \Phpactor\WorseReflection\Core\Type\LiteralTrait;
    public function __construct(public string $value)
    {
    }
    public function __toString() : string
    {
        return \sprintf('"%s"', $this->value);
    }
    public function value() : string
    {
        return $this->value;
    }
    public function generalize() : Type
    {
        return new \Phpactor\WorseReflection\Core\Type\StringType();
    }
    public function concat(Type $right) : Type
    {
        if ($right instanceof \Phpactor\WorseReflection\Core\Type\StringLiteralType) {
            return new self(\sprintf('%s%s', $this->value, (string) $right->value()));
        }
        return new \Phpactor\WorseReflection\Core\Type\StringType();
    }
    public function accepts(Type $type) : Trinary
    {
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\StringLiteralType) {
            return Trinary::fromBoolean($type->equals($this));
        }
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\StringType) {
            return Trinary::maybe();
        }
        return parent::accepts($type);
    }
}
