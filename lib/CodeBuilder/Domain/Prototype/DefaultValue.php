<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

final class DefaultValue extends \Phpactor\CodeBuilder\Domain\Prototype\Value
{
    private $none = \false;
    public static function none()
    {
        $new = new static();
        $new->none = \true;
        return $new;
    }
    public static function null() : \Phpactor\CodeBuilder\Domain\Prototype\DefaultValue
    {
        return new static(null);
    }
    public function notNone()
    {
        return \false === $this->none;
    }
}
