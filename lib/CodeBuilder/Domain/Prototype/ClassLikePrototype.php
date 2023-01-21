<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

abstract class ClassLikePrototype extends \Phpactor\CodeBuilder\Domain\Prototype\Prototype
{
    private \Phpactor\CodeBuilder\Domain\Prototype\Methods $methods;
    private \Phpactor\CodeBuilder\Domain\Prototype\Properties $properties;
    private \Phpactor\CodeBuilder\Domain\Prototype\Constants $constants;
    public function __construct(private string $name, \Phpactor\CodeBuilder\Domain\Prototype\Methods $methods = null, \Phpactor\CodeBuilder\Domain\Prototype\Properties $properties = null, \Phpactor\CodeBuilder\Domain\Prototype\Constants $constants = null, \Phpactor\CodeBuilder\Domain\Prototype\UpdatePolicy $updatePolicy = null)
    {
        parent::__construct($updatePolicy);
        $this->methods = $methods ?: \Phpactor\CodeBuilder\Domain\Prototype\Methods::empty();
        $this->properties = $properties ?: \Phpactor\CodeBuilder\Domain\Prototype\Properties::empty();
        $this->constants = $constants ?: \Phpactor\CodeBuilder\Domain\Prototype\Constants::empty();
    }
    public function name()
    {
        return $this->name;
    }
    public function methods() : \Phpactor\CodeBuilder\Domain\Prototype\Methods
    {
        return $this->methods;
    }
    public function properties() : \Phpactor\CodeBuilder\Domain\Prototype\Properties
    {
        return $this->properties;
    }
    public function constants() : \Phpactor\CodeBuilder\Domain\Prototype\Constants
    {
        return $this->constants;
    }
}
