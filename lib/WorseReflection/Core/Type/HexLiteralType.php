<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\Type;
final class HexLiteralType extends \Phpactor\WorseReflection\Core\Type\IntType implements \Phpactor\WorseReflection\Core\Type\Literal, \Phpactor\WorseReflection\Core\Type\Generalizable
{
    use \Phpactor\WorseReflection\Core\Type\LiteralTrait;
    public function __construct(public string $value)
    {
    }
    public function __toString() : string
    {
        return (string) $this->value;
    }
    public function value()
    {
        return \hexdec(\substr($this->value, 2));
    }
    public function generalize() : Type
    {
        return new \Phpactor\WorseReflection\Core\Type\IntType();
    }
}
