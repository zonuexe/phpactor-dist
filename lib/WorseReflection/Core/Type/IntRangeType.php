<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
final class IntRangeType extends IntType
{
    public function __construct(public Type $lower, public Type $upper)
    {
    }
    public function __toString() : string
    {
        return \sprintf('int<%s, %s>', $this->lower->__toString(), $this->upper->__toString());
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\IntRangeType', 'Phpactor\\WorseReflection\\Core\\Type\\IntRangeType', \false);
