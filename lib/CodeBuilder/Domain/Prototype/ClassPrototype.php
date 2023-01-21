<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

final class ClassPrototype extends \Phpactor\CodeBuilder\Domain\Prototype\ClassLikePrototype
{
    private ?\Phpactor\CodeBuilder\Domain\Prototype\ExtendsClass $extendsClass;
    private ?\Phpactor\CodeBuilder\Domain\Prototype\ImplementsInterfaces $implementsInterfaces;
    public function __construct(string $name, \Phpactor\CodeBuilder\Domain\Prototype\Properties $properties = null, \Phpactor\CodeBuilder\Domain\Prototype\Constants $constants = null, \Phpactor\CodeBuilder\Domain\Prototype\Methods $methods = null, \Phpactor\CodeBuilder\Domain\Prototype\ExtendsClass $extendsClass = null, \Phpactor\CodeBuilder\Domain\Prototype\ImplementsInterfaces $implementsInterfaces = null, \Phpactor\CodeBuilder\Domain\Prototype\UpdatePolicy $updatePolicy = null)
    {
        parent::__construct($name, $methods, $properties, $constants, $updatePolicy);
        $this->extendsClass = $extendsClass ?: \Phpactor\CodeBuilder\Domain\Prototype\ExtendsClass::none();
        $this->implementsInterfaces = $implementsInterfaces ?: \Phpactor\CodeBuilder\Domain\Prototype\ImplementsInterfaces::empty();
    }
    public function extendsClass() : \Phpactor\CodeBuilder\Domain\Prototype\ExtendsClass
    {
        return $this->extendsClass;
    }
    public function implementsInterfaces() : \Phpactor\CodeBuilder\Domain\Prototype\ImplementsInterfaces
    {
        return $this->implementsInterfaces;
    }
}
