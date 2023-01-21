<?php

namespace Phpactor\ClassMover\Domain\Reference;

use IteratorAggregate;
use Countable;
use ArrayIterator;
use Traversable;
final class MemberReferences implements IteratorAggregate, Countable
{
    private $methodReferences = [];
    private function __construct($methodReferences)
    {
        foreach ($methodReferences as $item) {
            $this->add($item);
        }
    }
    public static function fromMemberReferences(array $methodReferences) : \Phpactor\ClassMover\Domain\Reference\MemberReferences
    {
        return new self($methodReferences);
    }
    public function getIterator() : Traversable
    {
        return new ArrayIterator($this->methodReferences);
    }
    public function withClasses() : \Phpactor\ClassMover\Domain\Reference\MemberReferences
    {
        return self::fromMemberReferences(\array_filter($this->methodReferences, function (\Phpactor\ClassMover\Domain\Reference\MemberReference $reference) {
            return $reference->hasClass();
        }));
    }
    public function withoutClasses() : \Phpactor\ClassMover\Domain\Reference\MemberReferences
    {
        return self::fromMemberReferences(\array_filter($this->methodReferences, function (\Phpactor\ClassMover\Domain\Reference\MemberReference $reference) {
            return \false === $reference->hasClass();
        }));
    }
    public function count() : int
    {
        return \count($this->methodReferences);
    }
    public function unique() : self
    {
        $members = [];
        return self::fromMemberReferences(\array_filter($this->methodReferences, function (\Phpactor\ClassMover\Domain\Reference\MemberReference $reference) use(&$members) {
            $hash = \sprintf('%s.%s.%s', $reference->methodName(), $reference->position()->start(), $reference->position()->end());
            $inArray = \false === \in_array($hash, $members);
            $members[] = $hash;
            return $inArray;
        }));
    }
    private function add(\Phpactor\ClassMover\Domain\Reference\MemberReference $item) : void
    {
        $this->methodReferences[] = $item;
    }
}
