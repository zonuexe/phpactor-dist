<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Trinary;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
class NotType extends Type
{
    public function __construct(public Type $type)
    {
    }
    public function __toString() : string
    {
        return \sprintf('not<%s>', $this->type);
    }
    public function toPhpString() : string
    {
        return '';
    }
    public function accepts(Type $type) : Trinary
    {
        return Trinary::maybe();
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\NotType', 'Phpactor\\WorseReflection\\Core\\Type\\NotType', \false);
