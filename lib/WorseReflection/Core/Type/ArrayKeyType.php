<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Trinary;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
class ArrayKeyType extends ScalarType
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
        if ($type instanceof IntType) {
            return Trinary::true();
        }
        if ($type instanceof FloatType) {
            return Trinary::true();
        }
        if ($type instanceof StringType) {
            return Trinary::true();
        }
        return Trinary::false();
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\ArrayKeyType', 'Phpactor\\WorseReflection\\Core\\Type\\ArrayKeyType', \false);
