<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core;

final class DefaultValue
{
    private $undefined = \false;
    private function __construct(private $value = null)
    {
    }
    public static function fromValue($value) : DefaultValue
    {
        return new self($value);
    }
    public static function undefined() : DefaultValue
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
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\DefaultValue', 'Phpactor\\WorseReflection\\Core\\DefaultValue', \false);
