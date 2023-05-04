<?php

namespace Phpactor\ClassMover\Domain\Name;

class FullyQualifiedName extends \Phpactor\ClassMover\Domain\Name\QualifiedName
{
    public static function fromString(string $string) : static
    {
        return parent::fromString(\trim($string, '\\'));
    }
}
