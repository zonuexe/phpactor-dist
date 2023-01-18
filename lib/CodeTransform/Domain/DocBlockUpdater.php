<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain;

use Phpactor202301\Phpactor\CodeTransform\Domain\DocBlockUpdater\TagPrototype;
interface DocBlockUpdater
{
    public function set(string $docblock, TagPrototype $prototype) : string;
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\DocBlockUpdater', 'Phpactor\\CodeTransform\\Domain\\DocBlockUpdater', \false);
