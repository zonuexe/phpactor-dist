<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

final class Parameter extends \Phpactor\CodeBuilder\Domain\Prototype\Prototype
{
    private \Phpactor\CodeBuilder\Domain\Prototype\Type $type;
    private \Phpactor\CodeBuilder\Domain\Prototype\DefaultValue $defaultValue;
    public function __construct(private string $name, \Phpactor\CodeBuilder\Domain\Prototype\Type $type = null, \Phpactor\CodeBuilder\Domain\Prototype\DefaultValue $defaultValue = null, private bool $byReference = \false, \Phpactor\CodeBuilder\Domain\Prototype\UpdatePolicy $updatePolicy = null, private bool $isVariadic = \false, private ?\Phpactor\CodeBuilder\Domain\Prototype\Visibility $visibility = null)
    {
        parent::__construct($updatePolicy);
        $this->type = $type ?: \Phpactor\CodeBuilder\Domain\Prototype\Type::none();
        $this->defaultValue = $defaultValue ?: \Phpactor\CodeBuilder\Domain\Prototype\DefaultValue::none();
        $this->updatePolicy = $updatePolicy;
    }
    public function name() : string
    {
        return $this->name;
    }
    public function type() : \Phpactor\CodeBuilder\Domain\Prototype\Type
    {
        return $this->type;
    }
    public function defaultValue() : \Phpactor\CodeBuilder\Domain\Prototype\DefaultValue
    {
        return $this->defaultValue;
    }
    public function byReference() : bool
    {
        return $this->byReference;
    }
    public function visibility() : ?\Phpactor\CodeBuilder\Domain\Prototype\Visibility
    {
        return $this->visibility;
    }
    public function isVariadic() : bool
    {
        return $this->isVariadic;
    }
}
