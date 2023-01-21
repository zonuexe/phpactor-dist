<?php

namespace Phpactor\CodeBuilder\Domain\Builder;

use Phpactor\CodeBuilder\Domain\Prototype\Constant;
use Phpactor\CodeBuilder\Domain\Prototype\UpdatePolicy;
use Phpactor\CodeBuilder\Domain\Prototype\Value;
class ConstantBuilder extends \Phpactor\CodeBuilder\Domain\Builder\AbstractBuilder implements \Phpactor\CodeBuilder\Domain\Builder\NamedBuilder
{
    /**
     * @var mixed
     */
    protected $value;
    public function __construct(private \Phpactor\CodeBuilder\Domain\Builder\ClassLikeBuilder $parent, protected string $name, $value)
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
    public function end() : \Phpactor\CodeBuilder\Domain\Builder\ClassLikeBuilder
    {
        return $this->parent;
    }
    public function builderName() : string
    {
        return $this->name;
    }
}
