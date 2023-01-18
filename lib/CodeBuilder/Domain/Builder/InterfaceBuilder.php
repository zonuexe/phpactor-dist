<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Builder;

use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Type;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Methods;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\ExtendsInterfaces;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\InterfacePrototype;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\UpdatePolicy;
class InterfaceBuilder extends ClassLikeBuilder
{
    /**
     * @var Type[]
     */
    protected array $extends = [];
    public static function childNames() : array
    {
        return [];
    }
    public function extends(string $class) : InterfaceBuilder
    {
        $this->extends[] = Type::fromString($class);
        return $this;
    }
    public function build() : InterfacePrototype
    {
        return new InterfacePrototype($this->name, Methods::fromMethods(\array_map(function (MethodBuilder $builder) {
            return $builder->build();
        }, $this->methods)), ExtendsInterfaces::fromTypes($this->extends), UpdatePolicy::fromModifiedState($this->isModified()));
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Builder\\InterfaceBuilder', 'Phpactor\\CodeBuilder\\Domain\\Builder\\InterfaceBuilder', \false);
