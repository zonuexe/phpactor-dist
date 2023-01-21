<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\Type;
class FloatType extends \Phpactor\WorseReflection\Core\Type\NumericType implements \Phpactor\WorseReflection\Core\Type\HasEmptyType
{
    public function toPhpString() : string
    {
        return 'float';
    }
    public function emptyType() : Type
    {
        return new \Phpactor\WorseReflection\Core\Type\FloatLiteralType(0.0);
    }
}
