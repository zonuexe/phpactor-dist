<?php

namespace Phpactor202301\Phpactor\Completion\Core;

use Generator;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
interface Completor
{
    /**
     * @return Generator<int, Suggestion, null, bool>
     */
    public function complete(TextDocument $source, ByteOffset $byteOffset) : Generator;
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Core\\Completor', 'Phpactor\\Completion\\Core\\Completor', \false);
