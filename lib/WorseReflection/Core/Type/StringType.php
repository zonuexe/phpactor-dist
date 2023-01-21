<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\Type;
class StringType extends \Phpactor\WorseReflection\Core\Type\ScalarType implements \Phpactor\WorseReflection\Core\Type\HasEmptyType
{
    public function toPhpString() : string
    {
        return 'string';
    }
    public function emptyType() : Type
    {
        return new \Phpactor\WorseReflection\Core\Type\StringLiteralType('');
    }
}
