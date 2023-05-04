<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

/**
 * @extends Collection<TraitPrototype>
 */
class Traits extends \Phpactor\CodeBuilder\Domain\Prototype\Collection
{
    /**
     * @param list<TraitPrototype> $traits
     */
    public static function fromTraits(array $traits) : self
    {
        return new static(\array_reduce($traits, function ($arr, \Phpactor\CodeBuilder\Domain\Prototype\TraitPrototype $trait) {
            $arr[$trait->name()] = $trait;
            return $arr;
        }, []));
    }
    protected function singularName() : string
    {
        return 'trait';
    }
}
