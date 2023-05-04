<?php

namespace Phpactor\ClassMover\Domain\Name;

final class ImportedName extends \Phpactor\ClassMover\Domain\Name\Namespace_
{
    private ?string $alias = null;
    public function __toString() : string
    {
        return \implode('\\', $this->parts);
    }
    public function getShortName() : string
    {
        /** @var string $lastPart */
        $lastPart = \end($this->parts);
        return $lastPart;
    }
    public function qualifies(\Phpactor\ClassMover\Domain\Name\QualifiedName $name) : bool
    {
        $head = $this->alias ?: $this->head();
        $qualifies = $head === $name->base();
        return $qualifies;
    }
    public function qualify(\Phpactor\ClassMover\Domain\Name\QualifiedName $name) : \Phpactor\ClassMover\Domain\Name\FullyQualifiedName
    {
        return \Phpactor\ClassMover\Domain\Name\FullyQualifiedName::fromString($this->parentNamespace()->__toString() . '\\' . $name->__toString());
    }
    public function withAlias(string $alias) : self
    {
        $new = new self($this->parts);
        $new->alias = $alias;
        return $new;
    }
    public function isAlias() : bool
    {
        return null !== $this->alias;
    }
    public static function fromStringAsAlias(string $string) : self
    {
        return parent::fromString($string);
    }
}
