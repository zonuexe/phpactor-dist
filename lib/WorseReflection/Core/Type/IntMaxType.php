<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

class IntMaxType extends IntType
{
    public function __toString() : string
    {
        return 'max';
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\IntMaxType', 'Phpactor\\WorseReflection\\Core\\Type\\IntMaxType', \false);
