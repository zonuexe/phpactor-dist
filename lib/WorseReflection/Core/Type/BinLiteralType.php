<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

final class BinLiteralType extends IntType implements Literal
{
    use LiteralTrait;
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
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\BinLiteralType', 'Phpactor\\WorseReflection\\Core\\Type\\BinLiteralType', \false);
