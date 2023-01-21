<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

final class Line
{
    private function __construct(private $line)
    {
    }
    public function __toString()
    {
        return $this->line;
    }
    public static function fromString(string $line) : \Phpactor\CodeBuilder\Domain\Prototype\Line
    {
        return new self($line);
    }
}
