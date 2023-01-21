<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

final class TraitPrototype extends \Phpactor\CodeBuilder\Domain\Prototype\ClassLikePrototype
{
    public function __construct(string $name, \Phpactor\CodeBuilder\Domain\Prototype\Properties $properties = null, \Phpactor\CodeBuilder\Domain\Prototype\Constants $constants = null, \Phpactor\CodeBuilder\Domain\Prototype\Methods $methods = null, \Phpactor\CodeBuilder\Domain\Prototype\UpdatePolicy $updatePolicy = null)
    {
        parent::__construct($name, $methods, $properties, $constants, $updatePolicy);
    }
}
