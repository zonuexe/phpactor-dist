<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Trinary;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
final class VoidType extends PrimitiveType
{
    public function __toString() : string
    {
        return 'void';
    }
    public function toPhpString() : string
    {
        return $this->__toString();
    }
    public function accepts(Type $type) : Trinary
    {
        return Trinary::false();
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\VoidType', 'Phpactor\\WorseReflection\\Core\\Type\\VoidType', \false);
