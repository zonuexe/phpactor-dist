<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype;

class QualifiedName
{
    protected function __construct(private string $name)
    {
    }
    public function __toString()
    {
        return $this->name;
    }
    public static function fromString(string $name) : QualifiedName
    {
        return new static($name);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Prototype\\QualifiedName', 'Phpactor\\CodeBuilder\\Domain\\Prototype\\QualifiedName', \false);
