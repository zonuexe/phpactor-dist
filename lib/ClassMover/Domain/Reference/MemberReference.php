<?php

namespace Phpactor\ClassMover\Domain\Reference;

use Phpactor\ClassMover\Domain\Name\MemberName;
use Phpactor\ClassMover\Domain\Model\Class_;
class MemberReference
{
    private function __construct(private MemberName $method, private \Phpactor\ClassMover\Domain\Reference\Position $position, private ?Class_ $class = null)
    {
    }
    public function __toString() : string
    {
        return \sprintf('[%s:%s] %s', $this->position->start(), $this->position->end(), (string) $this->method);
    }
    public static function fromMemberNameAndPosition(MemberName $method, \Phpactor\ClassMover\Domain\Reference\Position $position) : \Phpactor\ClassMover\Domain\Reference\MemberReference
    {
        return new self($method, $position);
    }
    public static function fromMemberNamePositionAndClass(MemberName $method, \Phpactor\ClassMover\Domain\Reference\Position $position, Class_ $class) : \Phpactor\ClassMover\Domain\Reference\MemberReference
    {
        return new self($method, $position, $class);
    }
    public function methodName() : MemberName
    {
        return $this->method;
    }
    public function position() : \Phpactor\ClassMover\Domain\Reference\Position
    {
        return $this->position;
    }
    public function hasClass() : bool
    {
        return null !== $this->class;
    }
    public function withClass(Class_ $class) : self
    {
        return new self($this->method, $this->position, $class);
    }
    public function class() : ?Class_
    {
        return $this->class;
    }
}
