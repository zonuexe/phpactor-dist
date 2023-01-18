<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Trinary;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
final class MissingType extends Type
{
    public function __toString() : string
    {
        return '<missing>';
    }
    public function toPhpString() : string
    {
        return '';
    }
    public function accepts(Type $type) : Trinary
    {
        return Trinary::true();
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\MissingType', 'Phpactor\\WorseReflection\\Core\\Type\\MissingType', \false);
