<?php

namespace Phpactor\CodeBuilder\Domain\Builder;

use Phpactor\CodeBuilder\Domain\Prototype\Type;
use Phpactor\CodeBuilder\Domain\Prototype\DefaultValue;
use Phpactor\CodeBuilder\Domain\Prototype\Parameter;
use Phpactor\CodeBuilder\Domain\Prototype\UpdatePolicy;
use Phpactor\CodeBuilder\Domain\Prototype\Visibility;
use Exception;
class ParameterBuilder extends \Phpactor\CodeBuilder\Domain\Builder\AbstractBuilder
{
    protected ?Type $type = null;
    protected ?DefaultValue $defaultValue = null;
    protected bool $byReference = \false;
    protected bool $variadic = \false;
    protected ?Visibility $visibility = null;
    public function __construct(private \Phpactor\CodeBuilder\Domain\Builder\MethodBuilder $parent, protected string $name)
    {
    }
    /**
     * @return array{}
     */
    public static function childNames() : array
    {
        return [];
    }
    /**
     * @param mixed $originalType
     */
    public function type(string $type, $originalType = null) : \Phpactor\CodeBuilder\Domain\Builder\ParameterBuilder
    {
        $this->type = new Type($type, $originalType);
        return $this;
    }
    public function visibility(?Visibility $visibility) : \Phpactor\CodeBuilder\Domain\Builder\ParameterBuilder
    {
        $methodName = $this->parent->builderName();
        if ($methodName !== '__construct') {
            throw new Exception('Only constructors can have parameters with visibility. Current function: ' . $methodName);
        }
        $this->visibility = $visibility;
        return $this;
    }
    public function defaultValue($value) : \Phpactor\CodeBuilder\Domain\Builder\ParameterBuilder
    {
        $this->defaultValue = DefaultValue::fromValue($value);
        return $this;
    }
    public function build() : Parameter
    {
        return new Parameter($this->name, $this->type, $this->defaultValue, $this->byReference, UpdatePolicy::fromModifiedState($this->isModified()), $this->variadic, $this->visibility);
    }
    public function end() : \Phpactor\CodeBuilder\Domain\Builder\MethodBuilder
    {
        return $this->parent;
    }
    public function byReference(bool $bool) : self
    {
        $this->byReference = $bool;
        return $this;
    }
    public function asVariadic() : self
    {
        $this->variadic = \true;
        return $this;
    }
}
