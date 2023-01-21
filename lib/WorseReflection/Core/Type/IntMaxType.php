<?php

namespace Phpactor\WorseReflection\Core\Type;

class IntMaxType extends \Phpactor\WorseReflection\Core\Type\IntType
{
    public function __toString() : string
    {
        return 'max';
    }
}
