<?php

namespace Phpactor\TextDocument;

final class LineColRange
{
    public function __construct(private \Phpactor\TextDocument\LineCol $start, private \Phpactor\TextDocument\LineCol $end)
    {
    }
    public function start() : \Phpactor\TextDocument\LineCol
    {
        return $this->start;
    }
    public function end() : \Phpactor\TextDocument\LineCol
    {
        return $this->end;
    }
}
