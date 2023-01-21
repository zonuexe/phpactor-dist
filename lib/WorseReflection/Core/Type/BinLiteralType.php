<?php

namespace Phpactor\WorseReflection\Core\Type;

final class BinLiteralType extends \Phpactor\WorseReflection\Core\Type\IntType implements \Phpactor\WorseReflection\Core\Type\Literal
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
        return \bindec(\substr($this->value, 2));
    }
}
