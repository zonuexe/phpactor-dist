<?php

namespace Phpactor\Name;

final class FullyQualifiedName implements \Phpactor\Name\Name
{
    private function __construct(private \Phpactor\Name\QualifiedName $qualifiedName)
    {
    }
    public function __toString() : string
    {
        return $this->qualifiedName->__toString();
    }
    public static function fromArray(array $parts) : \Phpactor\Name\FullyQualifiedName
    {
        return new self(\Phpactor\Name\QualifiedName::fromArray($parts));
    }
    public static function fromString(string $string) : \Phpactor\Name\FullyQualifiedName
    {
        return new self(\Phpactor\Name\QualifiedName::fromString($string));
    }
    public static function fromQualifiedName(\Phpactor\Name\QualifiedName $qualfifiedName) : \Phpactor\Name\FullyQualifiedName
    {
        return new self($qualfifiedName);
    }
    /**
     * Reutrn the last element of the name (e.g. the class's short name)
     */
    public function head() : \Phpactor\Name\QualifiedName
    {
        return $this->qualifiedName->head();
    }
    /**
     * Return the "namespace" portion of the name.
     *
     * @return FullyQualifiedName
     */
    public function tail() : \Phpactor\Name\Name
    {
        return new self($this->qualifiedName->tail());
    }
    /**
     * @return FullyQualifiedName
     */
    public function prepend(\Phpactor\Name\Name $name) : \Phpactor\Name\Name
    {
        return new self($this->qualifiedName->prepend($name));
    }
    /**
     * @return FullyQualifiedName
     */
    public function append(\Phpactor\Name\Name $name) : \Phpactor\Name\Name
    {
        return new self($this->qualifiedName->append($name));
    }
    public function isDescendantOf(\Phpactor\Name\Name $name) : bool
    {
        return $this->qualifiedName->isDescendantOf($name);
    }
    public function toArray() : array
    {
        return $this->qualifiedName->toArray();
    }
    public function count() : int
    {
        return $this->qualifiedName->count();
    }
}
