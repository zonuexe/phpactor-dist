<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype;

final class ReturnType extends Prototype
{
    public function __construct(private Type $type)
    {
        parent::__construct();
    }
    public function __toString()
    {
        return (string) $this->type;
    }
    public static function fromString($string)
    {
        return new self(Type::fromString($string));
    }
    public static function none()
    {
        return new self(Type::none());
    }
    public function notNone() : bool
    {
        return $this->type->notNone();
    }
    public function type() : Type
    {
        return $this->type;
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Prototype\\ReturnType', 'Phpactor\\CodeBuilder\\Domain\\Prototype\\ReturnType', \false);
