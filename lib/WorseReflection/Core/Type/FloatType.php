<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
class FloatType extends NumericType implements HasEmptyType
{
    public function toPhpString() : string
    {
        return 'float';
    }
    public function emptyType() : Type
    {
        return new FloatLiteralType(0.0);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\FloatType', 'Phpactor\\WorseReflection\\Core\\Type\\FloatType', \false);
