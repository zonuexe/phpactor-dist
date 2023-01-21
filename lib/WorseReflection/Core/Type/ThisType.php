<?php

namespace Phpactor\WorseReflection\Core\Type;

final class ThisType extends \Phpactor\WorseReflection\Core\Type\StaticType
{
    public function __toString() : string
    {
        if ($this->class) {
            return \sprintf('$this(%s)', $this->class->__toString());
        }
        return '$this';
    }
}
