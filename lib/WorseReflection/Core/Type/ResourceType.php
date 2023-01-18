<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Trinary;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
final class ResourceType extends PrimitiveType
{
    public function __toString() : string
    {
        return 'resource';
    }
    public function toPhpString() : string
    {
        return 'resource';
    }
    public function accepts(Type $type) : Trinary
    {
        return Trinary::fromBoolean($type instanceof ResourceType);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\ResourceType', 'Phpactor\\WorseReflection\\Core\\Type\\ResourceType', \false);
