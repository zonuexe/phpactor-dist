<?php

namespace Phpactor202301\Phpactor\TextDocument;

use Iterator;
use IteratorAggregate;
/**
 * @implements IteratorAggregate<int, TextEdit>
 */
class TextDocumentEdits implements IteratorAggregate
{
    public function __construct(private TextDocumentUri $uri, private TextEdits $textEdits)
    {
    }
    public function uri() : TextDocumentUri
    {
        return $this->uri;
    }
    public function textEdits() : TextEdits
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
/**
 * @implements IteratorAggregate<int, TextEdit>
 */
\class_alias('Phpactor202301\\Phpactor\\TextDocument\\TextDocumentEdits', 'Phpactor\\TextDocument\\TextDocumentEdits', \false);
