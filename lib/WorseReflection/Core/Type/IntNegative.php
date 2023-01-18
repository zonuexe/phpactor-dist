<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

class IntNegative extends IntType
{
    public function __toString() : string
    {
        return 'negative-int';
    }
    public function toPhpString() : string
    {
        return 'int';
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\IntNegative', 'Phpactor\\WorseReflection\\Core\\Type\\IntNegative', \false);
