<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

/**
 * @extends Collection<Parameter>
 */
class Parameters extends \Phpactor\CodeBuilder\Domain\Prototype\Collection
{
    /**
     * @param array<Parameter> $parameters
     */
    public static function fromParameters(array $parameters) : self
    {
        return new self($parameters);
    }
    protected function singularName() : string
    {
        return 'parameter';
    }
}
