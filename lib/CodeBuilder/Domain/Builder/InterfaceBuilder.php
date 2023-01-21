<?php

namespace Phpactor\CodeBuilder\Domain\Builder;

use Phpactor\CodeBuilder\Domain\Prototype\Type;
use Phpactor\CodeBuilder\Domain\Prototype\Methods;
use Phpactor\CodeBuilder\Domain\Prototype\ExtendsInterfaces;
use Phpactor\CodeBuilder\Domain\Prototype\InterfacePrototype;
use Phpactor\CodeBuilder\Domain\Prototype\UpdatePolicy;
class InterfaceBuilder extends \Phpactor\CodeBuilder\Domain\Builder\ClassLikeBuilder
{
    /**
     * @var Type[]
     */
    protected array $extends = [];
    public static function childNames() : array
    {
        return [];
    }
    public function extends(string $class) : \Phpactor\CodeBuilder\Domain\Builder\InterfaceBuilder
    {
        $this->extends[] = Type::fromString($class);
        return $this;
    }
    public function build() : InterfacePrototype
    {
        return new InterfacePrototype($this->name, Methods::fromMethods(\array_map(function (\Phpactor\CodeBuilder\Domain\Builder\MethodBuilder $builder) {
            return $builder->build();
        }, $this->methods)), ExtendsInterfaces::fromTypes($this->extends), UpdatePolicy::fromModifiedState($this->isModified()));
    }
}
