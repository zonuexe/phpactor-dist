<?php

namespace Phpactor\WorseReflection\Core\Type;

class IntPositive extends \Phpactor\WorseReflection\Core\Type\IntType
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
