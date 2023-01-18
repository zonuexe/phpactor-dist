<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
final class OctalLiteralType extends IntType implements Literal, Generalizable
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
        return \octdec(\substr($this->value, 1));
    }
    public function generalize() : Type
    {
        return new IntType();
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\OctalLiteralType', 'Phpactor\\WorseReflection\\Core\\Type\\OctalLiteralType', \false);
