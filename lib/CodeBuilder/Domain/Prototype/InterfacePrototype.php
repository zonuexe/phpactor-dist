<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

final class InterfacePrototype extends \Phpactor\CodeBuilder\Domain\Prototype\ClassLikePrototype
{
    private \Phpactor\CodeBuilder\Domain\Prototype\ExtendsInterfaces $extendsInterfaces;
    public function __construct(string $name, \Phpactor\CodeBuilder\Domain\Prototype\Methods $methods = null, \Phpactor\CodeBuilder\Domain\Prototype\ExtendsInterfaces $extendsInterfaces = null, \Phpactor\CodeBuilder\Domain\Prototype\UpdatePolicy $updatePolicy = null)
    {
        parent::__construct($name, $methods, null, null, $updatePolicy);
        $this->extendsInterfaces = $extendsInterfaces ?: \Phpactor\CodeBuilder\Domain\Prototype\ExtendsInterfaces::empty();
    }
    public function extendsInterfaces() : \Phpactor\CodeBuilder\Domain\Prototype\ExtendsInterfaces
    {
        return $this->extendsInterfaces;
    }
}
