<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype;

/**
 * @extends Collection<Constant>
 */
class Constants extends Collection
{
    public static function fromConstants(array $constants)
    {
        return new static(\array_reduce($constants, function ($acc, $constant) {
            $acc[$constant->name()] = $constant;
            return $acc;
        }, []));
    }
    protected function singularName() : string
    {
        return 'constant';
    }
}
/**
 * @extends Collection<Constant>
 */
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Prototype\\Constants', 'Phpactor\\CodeBuilder\\Domain\\Prototype\\Constants', \false);
