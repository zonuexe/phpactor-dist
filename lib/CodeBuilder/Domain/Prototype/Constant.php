<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype;

class Constant extends Prototype
{
    public function __construct(private string $name, private Value $value, UpdatePolicy $updatePolicy = null)
    {
        parent::__construct($updatePolicy);
    }
    public function name() : string
    {
        return $this->name;
    }
    public function value() : Value
    {
        return $this->value;
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Prototype\\Constant', 'Phpactor\\CodeBuilder\\Domain\\Prototype\\Constant', \false);
