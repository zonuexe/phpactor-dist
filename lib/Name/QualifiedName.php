<?php

namespace Phpactor\Name;

use Phpactor\Name\Exception\InvalidName;
final class QualifiedName implements \Phpactor\Name\Name
{
    const NAMESPACE_SEPARATOR = '\\';
    private array $parts;
    private function __construct(array $parts)
    {
        if (empty($parts)) {
            throw new InvalidName(\sprintf('Names must have at least one segment'));
        }
        $this->parts = $parts;
    }
    public function __toString() : string
    {
        return \implode(self::NAMESPACE_SEPARATOR, $this->parts);
    }
    public static function fromArray(array $parts) : \Phpactor\Name\QualifiedName
    {
        return new self($parts);
    }
    public static function fromString(string $string) : \Phpactor\Name\QualifiedName
    {
        return new self(\array_filter(\explode(self::NAMESPACE_SEPARATOR, $string)));
    }
    public function toFullyQualifiedName() : \Phpactor\Name\FullyQualifiedName
    {
        return \Phpactor\Name\FullyQualifiedName::fromQualifiedName($this);
    }
    public function head() : \Phpactor\Name\QualifiedName
    {
        $parts = $this->parts;
        return new self([\array_pop($parts)]);
    }
    /**
     * @return QualifiedName
     */
    public function tail() : \Phpactor\Name\Name
    {
        $parts = $this->parts;
        \array_pop($parts);
        return new self($parts);
    }
    public function isDescendantOf(\Phpactor\Name\Name $name) : bool
    {
        return \array_slice($this->parts, 0, $name->count()) === $name->toArray();
    }
    /**
     * @return string[]
     */
    public function toArray() : array
    {
        return $this->parts;
    }
    public function count() : int
    {
        return \count($this->parts);
    }
    /**
     * @return QualifiedName
     */
    public function prepend(\Phpactor\Name\Name $name) : \Phpactor\Name\Name
    {
        $parts = $this->parts;
        \array_unshift($parts, ...$name->toArray());
        return new self($parts);
    }
    /**
     * @return QualifiedName
     */
    public function append(\Phpactor\Name\Name $name) : \Phpactor\Name\Name
    {
        $parts = $this->parts;
        $parts = \array_merge($parts, $name->toArray());
        return new self($parts);
    }
}
