<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Trinary;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
final class MixedType extends PrimitiveType
{
    public function __toString() : string
    {
        return 'mixed';
    }
    public function toPhpString() : string
    {
        return $this->__toString();
    }
    public function accepts(Type $type) : Trinary
    {
        return Trinary::true();
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\MixedType', 'Phpactor\\WorseReflection\\Core\\Type\\MixedType', \false);
