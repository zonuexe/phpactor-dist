<?php

namespace Phpactor202301\Phpactor\Rename\Model\Renamer;

use Generator;
use Phpactor202301\Phpactor\Rename\Model\Renamer;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class ChainRenamer implements Renamer
{
    /** @param Renamer[] $renamers */
    public function __construct(private array $renamers)
    {
    }
    public function getRenameRange(TextDocument $textDocument, ByteOffset $offset) : ?ByteOffsetRange
    {
        foreach ($this->renamers as $renamer) {
            if (null !== ($range = $renamer->getRenameRange($textDocument, $offset))) {
                return $range;
            }
        }
        return null;
    }
    public function rename(TextDocument $textDocument, ByteOffset $offset, string $newName) : Generator
    {
        foreach ($this->renamers as $renamer) {
            if (null !== ($range = $renamer->getRenameRange($textDocument, $offset))) {
                $rename = $renamer->rename($textDocument, $offset, $newName);
                yield from $rename;
                return $rename->getReturn();
            }
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\Rename\\Model\\Renamer\\ChainRenamer', 'Phpactor\\Rename\\Model\\Renamer\\ChainRenamer', \false);
