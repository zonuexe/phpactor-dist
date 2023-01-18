<?php

namespace Phpactor202301\Phpactor\TextDocument;

use ArrayIterator;
use Countable;
use Iterator;
use IteratorAggregate;
/**
 * @implements IteratorAggregate<int, TextDocumentEdits>
 */
final class WorkspaceEdits implements IteratorAggregate, Countable
{
    /**
     * @var TextDocumentEdits[]
     */
    private array $documentEdits;
    public function __construct(TextDocumentEdits ...$documentEdits)
    {
        $this->documentEdits = $documentEdits;
    }
    /**
     * @return Iterator<TextDocumentEdits>
     */
    public function getIterator() : Iterator
    {
        return new ArrayIterator($this->documentEdits);
    }
    public static function none() : self
    {
        return new self();
    }
    public function count() : int
    {
        return \count($this->documentEdits);
    }
}
/**
 * @implements IteratorAggregate<int, TextDocumentEdits>
 */
\class_alias('Phpactor202301\\Phpactor\\TextDocument\\WorkspaceEdits', 'Phpactor\\TextDocument\\WorkspaceEdits', \false);
