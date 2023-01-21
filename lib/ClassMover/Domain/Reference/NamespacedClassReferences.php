<?php

namespace Phpactor\ClassMover\Domain\Reference;

use Phpactor\ClassMover\Domain\Name\FullyQualifiedName;
use IteratorAggregate;
use ArrayIterator;
use Traversable;
/**
 * @implements IteratorAggregate<ClassReference>
 */
final class NamespacedClassReferences implements IteratorAggregate
{
    /**
     * @var ClassReference[]
     */
    private array $classRefs = [];
    /**
     * @param ClassReference[] $classRefs
     */
    private function __construct(private \Phpactor\ClassMover\Domain\Reference\NamespaceReference $namespaceRef, array $classRefs)
    {
        foreach ($classRefs as $classRef) {
            $this->add($classRef);
        }
    }
    /**
     * @param ClassReference[] $classRefs
     */
    public static function fromNamespaceAndClassRefs(\Phpactor\ClassMover\Domain\Reference\NamespaceReference $namespace, array $classRefs) : \Phpactor\ClassMover\Domain\Reference\NamespacedClassReferences
    {
        return new self($namespace, $classRefs);
    }
    public static function empty() : self
    {
        return new self(\Phpactor\ClassMover\Domain\Reference\NamespaceReference::forRoot(), []);
    }
    public function filterForName(FullyQualifiedName $name) : \Phpactor\ClassMover\Domain\Reference\NamespacedClassReferences
    {
        return new self($this->namespaceRef, \array_filter($this->classRefs, function (\Phpactor\ClassMover\Domain\Reference\ClassReference $classRef) use($name) {
            return $classRef->fullName()->isEqualTo($name);
        }));
    }
    public function isEmpty() : bool
    {
        return empty($this->classRefs);
    }
    public function getIterator() : Traversable
    {
        return new ArrayIterator($this->classRefs);
    }
    public function namespaceRef() : \Phpactor\ClassMover\Domain\Reference\NamespaceReference
    {
        return $this->namespaceRef;
    }
    private function add(\Phpactor\ClassMover\Domain\Reference\ClassReference $classRef) : void
    {
        $this->classRefs[] = $classRef;
    }
}
