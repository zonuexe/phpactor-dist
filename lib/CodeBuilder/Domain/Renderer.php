<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain;

use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Prototype;
interface Renderer
{
    public function render(Prototype $prototype, string $variant = null) : Code;
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Renderer', 'Phpactor\\CodeBuilder\\Domain\\Renderer', \false);
