<?php

namespace Phpactor\TextDocument;

use Iterator;
use IteratorAggregate;
/**
 * @implements IteratorAggregate<int, TextEdit>
 */
class TextDocumentEdits implements IteratorAggregate
{
    public function __construct(private \Phpactor\TextDocument\TextDocumentUri $uri, private \Phpactor\TextDocument\TextEdits $textEdits)
    {
    }
    public static function fromTextDocument(\Phpactor\TextDocument\TextDocument $textDocument, \Phpactor\TextDocument\TextEdits $edits) : self
    {
        return new self(\Phpactor\TextDocument\TextDocumentUri::fromString($textDocument->uriOrThrow()), $edits);
    }
    public function uri() : \Phpactor\TextDocument\TextDocumentUri
    {
        return $this->uri;
    }
    public function textEdits() : \Phpactor\TextDocument\TextEdits
    {
        return $this->textEdits;
    }
    /**
     * @return Iterator<TextEdit>
     */
    public function getIterator() : Iterator
    {
        return $this->textEdits->getIterator();
    }
}
