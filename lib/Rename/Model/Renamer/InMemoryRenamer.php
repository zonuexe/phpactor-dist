<?php

namespace Phpactor202301\Phpactor\Rename\Model\Renamer;

use Generator;
use Phpactor202301\Phpactor\Rename\Model\LocatedTextEdit;
use Phpactor202301\Phpactor\Rename\Model\Renamer;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class InMemoryRenamer implements Renamer
{
    /**
     * @param LocatedTextEdit[] $results
     */
    public function __construct(private ?ByteOffsetRange $range, private array $results = [])
    {
    }
    public function getRenameRange(TextDocument $textDocument, ByteOffset $offset) : ?ByteOffsetRange
    {
        return $this->range;
    }
    public function rename(TextDocument $textDocument, ByteOffset $offset, string $newName) : Generator
    {
        yield from $this->results;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Rename\\Model\\Renamer\\InMemoryRenamer', 'Phpactor\\Rename\\Model\\Renamer\\InMemoryRenamer', \false);
