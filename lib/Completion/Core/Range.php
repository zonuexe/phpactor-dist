<?php

namespace Phpactor202301\Phpactor\Completion\Core;

use Phpactor202301\Phpactor\TextDocument\ByteOffset;
class Range
{
    public function __construct(private ByteOffset $byteStart, private ByteOffset $byteEnd)
    {
    }
    public static function fromStartAndEnd(int $byteStart, int $byteEnd) : self
    {
        return new self(ByteOffset::fromInt($byteStart), ByteOffset::fromInt($byteEnd));
    }
    public function start() : ByteOffset
    {
        return $this->byteStart;
    }
    public function end() : ByteOffset
    {
        return $this->byteEnd;
    }
    public function toArray() : array
    {
        return [$this->byteStart->toInt(), $this->byteEnd->toInt()];
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Core\\Range', 'Phpactor\\Completion\\Core\\Range', \false);
