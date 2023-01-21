<?php

namespace Phpactor\TextDocument;

class ByteOffsetRange
{
    public function __construct(private \Phpactor\TextDocument\ByteOffset $start, private \Phpactor\TextDocument\ByteOffset $end)
    {
    }
    public static function fromInts(int $start, int $end) : self
    {
        return new self(\Phpactor\TextDocument\ByteOffset::fromInt($start), \Phpactor\TextDocument\ByteOffset::fromInt($end));
    }
    public static function fromByteOffsets(\Phpactor\TextDocument\ByteOffset $start, \Phpactor\TextDocument\ByteOffset $end) : self
    {
        return new self($start, $end);
    }
    public function start() : \Phpactor\TextDocument\ByteOffset
    {
        return $this->start;
    }
    public function end() : \Phpactor\TextDocument\ByteOffset
    {
        return $this->end;
    }
}
