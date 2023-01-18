<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype;

final class MethodBody extends Prototype
{
    public function __construct(private ?Lines $lines = null)
    {
        parent::__construct();
    }
    public static function fromLines(array $lines) : MethodBody
    {
        return new self(Lines::fromLines($lines));
    }
    public static function empty() : MethodBody
    {
        return new self(Lines::empty());
    }
    public static function none()
    {
        return new self();
    }
    public function lines() : ?Lines
    {
        return $this->lines;
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Prototype\\MethodBody', 'Phpactor\\CodeBuilder\\Domain\\Prototype\\MethodBody', \false);
