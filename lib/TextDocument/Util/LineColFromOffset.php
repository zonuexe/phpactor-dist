<?php

namespace Phpactor202301\Phpactor\TextDocument\Util;

use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\LineCol;
class LineColFromOffset
{
    /**
     * @deprecated Use LineCol Value object
     */
    public function __invoke(string $document, int $byteOffset) : LineCol
    {
        return LineCol::fromByteOffset($document, ByteOffset::fromInt($byteOffset));
    }
}
\class_alias('Phpactor202301\\Phpactor\\TextDocument\\Util\\LineColFromOffset', 'Phpactor\\TextDocument\\Util\\LineColFromOffset', \false);
