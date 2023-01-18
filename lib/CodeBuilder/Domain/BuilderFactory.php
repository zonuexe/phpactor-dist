<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain;

use Phpactor202301\Phpactor\CodeBuilder\Domain\Builder\SourceCodeBuilder;
interface BuilderFactory
{
    public function fromSource($source) : SourceCodeBuilder;
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\BuilderFactory', 'Phpactor\\CodeBuilder\\Domain\\BuilderFactory', \false);
