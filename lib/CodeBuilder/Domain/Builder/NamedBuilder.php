<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Builder;

interface NamedBuilder extends Builder
{
    public function builderName() : string;
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Builder\\NamedBuilder', 'Phpactor\\CodeBuilder\\Domain\\Builder\\NamedBuilder', \false);
