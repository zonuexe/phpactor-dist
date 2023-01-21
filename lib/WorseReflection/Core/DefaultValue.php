<?php

namespace Phpactor\WorseReflection\Core;

final class DefaultValue
{
    private $undefined = \false;
    private function __construct(private $value = null)
    {
    }
    public static function fromValue($value) : \Phpactor\WorseReflection\Core\DefaultValue
    {
        return new self($value);
    }
    public static function undefined() : \Phpactor\WorseReflection\Core\DefaultValue
    {
        $new = new self();
        $new->undefined = \true;
        return $new;
    }
    public function isDefined() : bool
    {
        return \false === $this->undefined;
    }
    public function value()
    {
        return $this->value;
    }
}
