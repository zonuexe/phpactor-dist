<?php

namespace Phpactor202301\Phpactor\ReferenceFinder;

use Generator;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
interface ReferenceFinder
{
    /**
     * Find references to the symbol at the given byte offset.
     *
     * @return Generator<PotentialLocation>
     */
    public function findReferences(TextDocument $document, ByteOffset $byteOffset) : Generator;
}
\class_alias('Phpactor202301\\Phpactor\\ReferenceFinder\\ReferenceFinder', 'Phpactor\\ReferenceFinder\\ReferenceFinder', \false);
