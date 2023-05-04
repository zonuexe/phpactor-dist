<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

abstract class ClassLikePrototype extends \Phpactor\CodeBuilder\Domain\Prototype\Prototype
{
    private \Phpactor\CodeBuilder\Domain\Prototype\Methods $methods;
    private \Phpactor\CodeBuilder\Domain\Prototype\Properties $properties;
    private \Phpactor\CodeBuilder\Domain\Prototype\Constants $constants;
    private \Phpactor\CodeBuilder\Domain\Prototype\Docblock $docblock;
    public function __construct(private string $name, \Phpactor\CodeBuilder\Domain\Prototype\Methods $methods = null, \Phpactor\CodeBuilder\Domain\Prototype\Properties $properties = null, \Phpactor\CodeBuilder\Domain\Prototype\Constants $constants = null, \Phpactor\CodeBuilder\Domain\Prototype\UpdatePolicy $updatePolicy = null, \Phpactor\CodeBuilder\Domain\Prototype\Docblock $docblock = null)
    {
        parent::__construct($updatePolicy);
        $this->methods = $methods ?: \Phpactor\CodeBuilder\Domain\Prototype\Methods::empty();
        $this->properties = $properties ?: \Phpactor\CodeBuilder\Domain\Prototype\Properties::empty();
        $this->constants = $constants ?: \Phpactor\CodeBuilder\Domain\Prototype\Constants::empty();
        $this->docblock = $docblock ?: \Phpactor\CodeBuilder\Domain\Prototype\Docblock::none();
    }
    public function name() : string
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
    public function docblock() : \Phpactor\CodeBuilder\Domain\Prototype\Docblock
    {
        return $this->docblock;
    }
}
