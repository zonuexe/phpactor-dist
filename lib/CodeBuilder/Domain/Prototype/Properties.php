<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype;

/**
 * @extends Collection<Property>
 */
class Properties extends Collection
{
    public static function fromProperties(array $properties)
    {
        return new static(\array_reduce($properties, function ($acc, $property) {
            $acc[$property->name()] = $property;
            return $acc;
        }, []));
    }
    protected function singularName() : string
    {
        return 'property';
    }
}
/**
 * @extends Collection<Property>
 */
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Prototype\\Properties', 'Phpactor\\CodeBuilder\\Domain\\Prototype\\Properties', \false);
