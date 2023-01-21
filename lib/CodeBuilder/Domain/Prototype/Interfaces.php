<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

/**
 * @extends Collection<InterfacePrototype>
 */
class Interfaces extends \Phpactor\CodeBuilder\Domain\Prototype\Collection
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
