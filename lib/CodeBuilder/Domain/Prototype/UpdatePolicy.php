<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype;

class UpdatePolicy
{
    public function __construct(private bool $doUpdate)
    {
    }
    public static function fromModifiedState(bool $modified)
    {
        return new self($modified);
    }
    public function applyUpdate() : bool
    {
        return $this->doUpdate;
    }
    public static function update() : UpdatePolicy
    {
        return new self(\true);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Prototype\\UpdatePolicy', 'Phpactor\\CodeBuilder\\Domain\\Prototype\\UpdatePolicy', \false);
