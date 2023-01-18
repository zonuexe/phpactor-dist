<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype;

/**
 * @extends Collection<Type>
 */
class ImplementsInterfaces extends Collection
{
    public function __toString()
    {
        return \implode(', ', \array_reduce($this->items, function ($acc, $interfaceName) {
            $acc[] = $interfaceName->__toString();
            return $acc;
        }));
    }
    public static function fromTypes(array $types)
    {
        return new static(\array_reduce($types, function ($acc, $type) {
            $acc[(string) $type] = $type;
            return $acc;
        }, []));
    }
    protected function singularName() : string
    {
        return 'implement interface';
    }
}
/**
 * @extends Collection<Type>
 */
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Prototype\\ImplementsInterfaces', 'Phpactor\\CodeBuilder\\Domain\\Prototype\\ImplementsInterfaces', \false);
