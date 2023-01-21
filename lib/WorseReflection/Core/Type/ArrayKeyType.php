<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\Trinary;
use Phpactor\WorseReflection\Core\Type;
class ArrayKeyType extends \Phpactor\WorseReflection\Core\Type\ScalarType
{
    public function __toString() : string
    {
        return 'array-key';
    }
    public function toPhpString() : string
    {
        return '';
    }
    public function accepts(Type $type) : Trinary
    {
        $parentAccepts = parent::accepts($type);
        if (!$parentAccepts->isFalse()) {
            return $parentAccepts;
        }
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\IntType) {
            return Trinary::true();
        }
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\FloatType) {
            return Trinary::true();
        }
        if ($type instanceof \Phpactor\WorseReflection\Core\Type\StringType) {
            return Trinary::true();
        }
        return Trinary::false();
    }
}
