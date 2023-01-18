<?php

namespace Phpactor202301\Phpactor\ClassMover\Domain\Model;

use Phpactor202301\Phpactor\ClassMover\Domain\Name\FullyQualifiedName;
class Class_
{
    private function __construct(private FullyQualifiedName $name)
    {
    }
    public function __toString()
    {
        return (string) $this->name;
    }
    public static function fromFullyQualifiedName(FullyQualifiedName $name)
    {
        return new self($name);
    }
    public static function fromString(string $name)
    {
        return self::fromFullyQualifiedName(FullyQualifiedName::fromString($name));
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Domain\\Model\\Class_', 'Phpactor\\ClassMover\\Domain\\Model\\Class_', \false);
