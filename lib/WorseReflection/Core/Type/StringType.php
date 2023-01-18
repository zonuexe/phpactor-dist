<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
class StringType extends ScalarType implements HasEmptyType
{
    public function toPhpString() : string
    {
        return 'string';
    }
    public function emptyType() : Type
    {
        return new StringLiteralType('');
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\StringType', 'Phpactor\\WorseReflection\\Core\\Type\\StringType', \false);
