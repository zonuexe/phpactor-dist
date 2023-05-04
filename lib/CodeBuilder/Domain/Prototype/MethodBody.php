<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

final class MethodBody extends \Phpactor\CodeBuilder\Domain\Prototype\Prototype
{
    public function __construct(private ?\Phpactor\CodeBuilder\Domain\Prototype\Lines $lines = null)
    {
        parent::__construct();
    }
    /**
     * @param array<Line> $lines
     */
    public static function fromLines(array $lines) : \Phpactor\CodeBuilder\Domain\Prototype\MethodBody
    {
        return new self(\Phpactor\CodeBuilder\Domain\Prototype\Lines::fromLines($lines));
    }
    public static function empty() : \Phpactor\CodeBuilder\Domain\Prototype\MethodBody
    {
        return new self(\Phpactor\CodeBuilder\Domain\Prototype\Lines::empty());
    }
    public static function none() : self
    {
        return new self();
    }
    public function lines() : ?\Phpactor\CodeBuilder\Domain\Prototype\Lines
    {
        return $this->lines;
    }
}
