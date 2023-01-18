<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype;

/**
 * @extends Collection<TraitPrototype>
 */
class Traits extends Collection
{
    public static function fromTraits(array $traits)
    {
        return new static(\array_reduce($traits, function ($arr, $trait) {
            $arr[$trait->name()] = $trait;
            return $arr;
        }, []));
    }
    protected function singularName() : string
    {
        return 'trait';
    }
}
/**
 * @extends Collection<TraitPrototype>
 */
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Prototype\\Traits', 'Phpactor\\CodeBuilder\\Domain\\Prototype\\Traits', \false);
