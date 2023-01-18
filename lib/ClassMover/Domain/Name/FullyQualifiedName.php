<?php

namespace Phpactor202301\Phpactor\ClassMover\Domain\Name;

class FullyQualifiedName extends QualifiedName
{
    public static function fromString(string $string)
    {
        return parent::fromString(\trim($string, '\\'));
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Domain\\Name\\FullyQualifiedName', 'Phpactor\\ClassMover\\Domain\\Name\\FullyQualifiedName', \false);
