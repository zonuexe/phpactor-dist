<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

class Prototype
{
    protected $updatePolicy;
    public function __construct(\Phpactor\CodeBuilder\Domain\Prototype\UpdatePolicy $updatePolicy = null)
    {
        $this->updatePolicy = $updatePolicy ?: \Phpactor\CodeBuilder\Domain\Prototype\UpdatePolicy::update();
    }
    public function applyUpdate() : bool
    {
        return $this->updatePolicy->applyUpdate();
    }
}
