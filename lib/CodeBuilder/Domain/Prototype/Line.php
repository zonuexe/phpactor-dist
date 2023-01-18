<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype;

final class Line
{
    private function __construct(private $line)
    {
    }
    public function __toString()
    {
        return $this->line;
    }
    public static function fromString(string $line) : Line
    {
        return new self($line);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Prototype\\Line', 'Phpactor\\CodeBuilder\\Domain\\Prototype\\Line', \false);
