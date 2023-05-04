<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\Type;
final class OctalLiteralType extends \Phpactor\WorseReflection\Core\Type\IntType implements \Phpactor\WorseReflection\Core\Type\Literal, \Phpactor\WorseReflection\Core\Type\Generalizable
{
    use \Phpactor\WorseReflection\Core\Type\LiteralTrait;
    public function __construct(public string $value)
    {
    }
    public function __toString() : string
    {
        return (string) $this->value;
    }
    public function value() : int|float
    {
        return \octdec(\substr($this->value, 1));
    }
    public function generalize() : Type
    {
        return new \Phpactor\WorseReflection\Core\Type\IntType();
    }
}
