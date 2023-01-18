<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype;

final class TraitPrototype extends ClassLikePrototype
{
    public function __construct(string $name, Properties $properties = null, Constants $constants = null, Methods $methods = null, UpdatePolicy $updatePolicy = null)
    {
        parent::__construct($name, $methods, $properties, $constants, $updatePolicy);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Prototype\\TraitPrototype', 'Phpactor\\CodeBuilder\\Domain\\Prototype\\TraitPrototype', \false);
