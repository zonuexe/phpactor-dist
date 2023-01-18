<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Trinary;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
class NeverType extends Type
{
    public function __toString() : string
    {
        return 'never';
    }
    public function toPhpString() : string
    {
        return 'never';
    }
    public function accepts(Type $type) : Trinary
    {
        return Trinary::false();
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\NeverType', 'Phpactor\\WorseReflection\\Core\\Type\\NeverType', \false);
