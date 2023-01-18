<?php

namespace Phpactor202301\Phpactor\ClassMover\Domain\Name;

class Namespace_ extends QualifiedName
{
    public function qualify(QualifiedName $name) : FullyQualifiedName
    {
        return FullyQualifiedName::fromString($this->__toString() . '\\' . $name->__toString());
    }
    public function isRoot() : bool
    {
        return \count($this->parts) === 0;
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Domain\\Name\\Namespace_', 'Phpactor\\ClassMover\\Domain\\Name\\Namespace_', \false);
