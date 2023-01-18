<?php

namespace Phpactor202301\Phpactor\ClassMover\Domain;

use Phpactor202301\Phpactor\ClassMover\Domain\Name\FullyQualifiedName;
use Phpactor202301\Phpactor\ClassMover\Domain\Reference\NamespacedClassReferences;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
interface ClassReplacer
{
    public function replaceReferences(TextDocument $source, NamespacedClassReferences $classRefList, FullyQualifiedName $originalName, FullyQualifiedName $newName) : TextEdits;
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Domain\\ClassReplacer', 'Phpactor\\ClassMover\\Domain\\ClassReplacer', \false);
