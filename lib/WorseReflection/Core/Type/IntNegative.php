<?php

namespace Phpactor\WorseReflection\Core\Type;

class IntNegative extends \Phpactor\WorseReflection\Core\Type\IntType
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
