<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

final class ExtendsClass extends \Phpactor\CodeBuilder\Domain\Prototype\Prototype
{
    public function __construct(private \Phpactor\CodeBuilder\Domain\Prototype\Type $class)
    {
        parent::__construct();
    }
    public function __toString() : string
    {
        return (string) $this->class;
    }
    public static function fromString(string $string) : self
    {
        return new self(\Phpactor\CodeBuilder\Domain\Prototype\Type::fromString($string));
    }
    public static function none() : self
    {
        return new self(\Phpactor\CodeBuilder\Domain\Prototype\Type::none());
    }
    public function notNone() : bool
    {
        return $this->class->notNone();
    }
}
