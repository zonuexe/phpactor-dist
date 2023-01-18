<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Builder;

use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Constant;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\UpdatePolicy;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Value;
class ConstantBuilder extends AbstractBuilder implements NamedBuilder
{
    /**
     * @var mixed
     */
    protected $value;
    public function __construct(private ClassLikeBuilder $parent, protected string $name, $value)
    {
        $this->value = Value::fromValue($value);
    }
    public static function childNames() : array
    {
        return [];
    }
    public function build() : Constant
    {
        return new Constant($this->name, $this->value, UpdatePolicy::fromModifiedState($this->isModified()));
    }
    public function end() : ClassLikeBuilder
    {
        return $this->parent;
    }
    public function builderName() : string
    {
        return $this->name;
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Builder\\ConstantBuilder', 'Phpactor\\CodeBuilder\\Domain\\Builder\\ConstantBuilder', \false);