<?php

namespace Phpactor202301\Phpactor\ClassMover\Domain\Name;

class Label
{
    private function __construct(private $label)
    {
    }
    public function __toString()
    {
        return $this->label;
    }
    public static function fromString(string $label) : Label
    {
        return new static($label);
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Domain\\Name\\Label', 'Phpactor\\ClassMover\\Domain\\Name\\Label', \false);
