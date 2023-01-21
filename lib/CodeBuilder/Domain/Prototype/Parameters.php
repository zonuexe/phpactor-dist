<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

/**
 * @extends Collection<Parameter>
 */
class Parameters extends \Phpactor\CodeBuilder\Domain\Prototype\Collection
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
