<?php

namespace Phpactor\ClassMover\Domain\Name;

class Label
{
    private function __construct(private string $label)
    {
    }
    public function __toString() : string
    {
        return $this->label;
    }
    public static function fromString(string $label) : \Phpactor\ClassMover\Domain\Name\Label
    {
        return new static($label);
    }
}
