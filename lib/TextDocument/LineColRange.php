<?php

namespace Phpactor202301\Phpactor\TextDocument;

final class LineColRange
{
    public function __construct(private LineCol $start, private LineCol $end)
    {
    }
    public function start() : LineCol
    {
        return $this->start;
    }
    public function end() : LineCol
    {
        return $this->end;
    }
}
\class_alias('Phpactor202301\\Phpactor\\TextDocument\\LineColRange', 'Phpactor\\TextDocument\\LineColRange', \false);
