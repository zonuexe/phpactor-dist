<?php

namespace Phpactor\ClassMover\Domain\Name;

class Namespace_ extends \Phpactor\ClassMover\Domain\Name\QualifiedName
{
    public function qualify(\Phpactor\ClassMover\Domain\Name\QualifiedName $name) : \Phpactor\ClassMover\Domain\Name\FullyQualifiedName
    {
        return \Phpactor\ClassMover\Domain\Name\FullyQualifiedName::fromString($this->__toString() . '\\' . $name->__toString());
    }
    public function isRoot() : bool
    {
        return \count($this->parts) === 0;
    }
}
