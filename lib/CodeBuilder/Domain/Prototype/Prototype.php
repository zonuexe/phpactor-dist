<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype;

class Prototype
{
    protected $updatePolicy;
    public function __construct(UpdatePolicy $updatePolicy = null)
    {
        $this->updatePolicy = $updatePolicy ?: UpdatePolicy::update();
    }
    public function applyUpdate() : bool
    {
        return $this->updatePolicy->applyUpdate();
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Prototype\\Prototype', 'Phpactor\\CodeBuilder\\Domain\\Prototype\\Prototype', \false);
