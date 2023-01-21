<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

final class Property extends \Phpactor\CodeBuilder\Domain\Prototype\Prototype
{
    private \Phpactor\CodeBuilder\Domain\Prototype\Visibility $visibility;
    private \Phpactor\CodeBuilder\Domain\Prototype\DefaultValue $defaultValue;
    private \Phpactor\CodeBuilder\Domain\Prototype\Type $type;
    private \Phpactor\CodeBuilder\Domain\Prototype\Type $docType;
    public function __construct(private string $name, \Phpactor\CodeBuilder\Domain\Prototype\Visibility $visibility = null, \Phpactor\CodeBuilder\Domain\Prototype\DefaultValue $defaultValue = null, \Phpactor\CodeBuilder\Domain\Prototype\Type $type = null, \Phpactor\CodeBuilder\Domain\Prototype\Type $docType = null, \Phpactor\CodeBuilder\Domain\Prototype\UpdatePolicy $updatePolicy = null)
    {
        parent::__construct($updatePolicy);
        $this->visibility = $visibility ?: \Phpactor\CodeBuilder\Domain\Prototype\Visibility::public();
        $this->defaultValue = $defaultValue ?: \Phpactor\CodeBuilder\Domain\Prototype\DefaultValue::none();
        $this->type = $type ?: \Phpactor\CodeBuilder\Domain\Prototype\Type::none();
        $this->docType = $docType ?: \Phpactor\CodeBuilder\Domain\Prototype\Type::none();
        $this->updatePolicy = $updatePolicy;
    }
    public function name() : string
    {
        return $this->name;
    }
    public function visibility() : \Phpactor\CodeBuilder\Domain\Prototype\Visibility
    {
        return $this->visibility;
    }
    public function defaultValue() : \Phpactor\CodeBuilder\Domain\Prototype\DefaultValue
    {
        return $this->defaultValue;
    }
    public function type() : \Phpactor\CodeBuilder\Domain\Prototype\Type
    {
        return $this->type;
    }
    public function docTypeOrType() : \Phpactor\CodeBuilder\Domain\Prototype\Type
    {
        if ($this->docType->notNone()) {
            return $this->docType;
        }
        return $this->type;
    }
    public function docType() : \Phpactor\CodeBuilder\Domain\Prototype\Type
    {
        return $this->docType;
    }
    public function docTypeAddsAdditionalInfo() : bool
    {
        return (string) $this->docType !== (string) $this->type;
    }
}
