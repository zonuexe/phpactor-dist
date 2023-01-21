<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

class Constant extends \Phpactor\CodeBuilder\Domain\Prototype\Prototype
{
    public function __construct(private string $name, private \Phpactor\CodeBuilder\Domain\Prototype\Value $value, \Phpactor\CodeBuilder\Domain\Prototype\UpdatePolicy $updatePolicy = null)
    {
        parent::__construct($updatePolicy);
    }
    public function name() : string
    {
        return $this->name;
    }
    public function value() : \Phpactor\CodeBuilder\Domain\Prototype\Value
    {
        return $this->value;
    }
}
