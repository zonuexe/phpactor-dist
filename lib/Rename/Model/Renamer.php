<?php

namespace Phpactor202301\Phpactor\Rename\Model;

use Generator;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
interface Renamer
{
    public function getRenameRange(TextDocument $textDocument, ByteOffset $offset) : ?ByteOffsetRange;
    /**
     * @return Generator<LocatedTextEdit>
     */
    public function rename(TextDocument $textDocument, ByteOffset $offset, string $newName) : Generator;
}
\class_alias('Phpactor202301\\Phpactor\\Rename\\Model\\Renamer', 'Phpactor\\Rename\\Model\\Renamer', \false);
