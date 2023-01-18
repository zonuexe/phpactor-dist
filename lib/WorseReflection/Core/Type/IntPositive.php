<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

class IntPositive extends IntType
{
    public function __toString() : string
    {
        return 'positive-int';
    }
    public function toPhpString() : string
    {
        return 'int';
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\IntPositive', 'Phpactor\\WorseReflection\\Core\\Type\\IntPositive', \false);
