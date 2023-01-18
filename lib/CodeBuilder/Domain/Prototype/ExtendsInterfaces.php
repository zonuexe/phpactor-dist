<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype;

/**
 * @extends Collection<Type>
 */
class ExtendsInterfaces extends Collection
{
    public static function fromTypes(array $types)
    {
        return new self($types);
    }
    protected function singularName() : string
    {
        return 'extend interface';
    }
}
/**
 * @extends Collection<Type>
 */
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Prototype\\ExtendsInterfaces', 'Phpactor\\CodeBuilder\\Domain\\Prototype\\ExtendsInterfaces', \false);
