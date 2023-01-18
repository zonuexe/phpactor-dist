<?php

namespace Phpactor202301\Phpactor\ClassMover\Domain;

use Phpactor202301\Phpactor\ClassMover\Domain\Reference\NamespacedClassReferences;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
interface ClassFinder
{
    public function findIn(TextDocument $source) : NamespacedClassReferences;
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Domain\\ClassFinder', 'Phpactor\\ClassMover\\Domain\\ClassFinder', \false);
