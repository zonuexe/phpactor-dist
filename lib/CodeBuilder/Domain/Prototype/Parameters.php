<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype;

/**
 * @extends Collection<Parameter>
 */
class Parameters extends Collection
{
    public static function fromParameters(array $parameters)
    {
        return new self($parameters);
    }
    protected function singularName() : string
    {
        return 'parameter';
    }
}
/**
 * @extends Collection<Parameter>
 */
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Prototype\\Parameters', 'Phpactor\\CodeBuilder\\Domain\\Prototype\\Parameters', \false);
