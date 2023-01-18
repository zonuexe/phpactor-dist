<?php

namespace Phpactor202301\Phpactor\ClassMover;

use Phpactor202301\Phpactor\ClassMover\Domain\Name\FullyQualifiedName;
use Phpactor202301\Phpactor\ClassMover\Domain\Reference\NamespacedClassReferences;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
final class FoundReferences
{
    public function __construct(private TextDocument $source, private FullyQualifiedName $name, private NamespacedClassReferences $references)
    {
    }
    public function source() : TextDocument
    {
        return $this->source;
    }
    public function targetName() : FullyQualifiedName
    {
        return $this->name;
    }
    public function references() : NamespacedClassReferences
    {
        return $this->references;
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\FoundReferences', 'Phpactor\\ClassMover\\FoundReferences', \false);
