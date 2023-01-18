<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype;

/**
 * @extends Collection<InterfacePrototype>
 */
class Interfaces extends Collection
{
    public static function fromInterfaces(array $interfaces) : self
    {
        return new static($interfaces);
    }
    protected function singularName() : string
    {
        return 'interface';
    }
}
/**
 * @extends Collection<InterfacePrototype>
 */
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Prototype\\Interfaces', 'Phpactor\\CodeBuilder\\Domain\\Prototype\\Interfaces', \false);
