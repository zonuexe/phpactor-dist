<?php

namespace Phpactor\TextDocument;

class Location
{
    public function __construct(private \Phpactor\TextDocument\TextDocumentUri $uri, private \Phpactor\TextDocument\ByteOffset $offset)
    {
    }
    public static function fromPathAndOffset(string $string, int $int) : \Phpactor\TextDocument\Location
    {
        return new self(\Phpactor\TextDocument\TextDocumentUri::fromString($string), \Phpactor\TextDocument\ByteOffset::fromInt($int));
    }
    public function uri() : \Phpactor\TextDocument\TextDocumentUri
    {
        return $this->uri;
    }
    public function offset() : \Phpactor\TextDocument\ByteOffset
    {
        return $this->offset;
    }
}
