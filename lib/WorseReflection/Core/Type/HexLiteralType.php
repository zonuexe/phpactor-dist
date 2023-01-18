<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
final class HexLiteralType extends IntType implements Literal, Generalizable
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
        return \hexdec(\substr($this->value, 2));
    }
    public function generalize() : Type
    {
        return new IntType();
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\HexLiteralType', 'Phpactor\\WorseReflection\\Core\\Type\\HexLiteralType', \false);
