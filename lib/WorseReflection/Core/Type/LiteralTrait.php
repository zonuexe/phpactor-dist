<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

trait LiteralTrait
{
    public function withValue($value) : self
    {
        $new = clone $this;
        $new->value = $value;
        return $new;
    }
}
