<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\Trinary;
use Phpactor\WorseReflection\Core\Type;
final class ResourceType extends \Phpactor\WorseReflection\Core\Type\PrimitiveType
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
        return Trinary::fromBoolean($type instanceof \Phpactor\WorseReflection\Core\Type\ResourceType);
    }
}
