<?php

namespace Phpactor202301\Phpactor\TextDocument;

class Location
{
    public function __construct(private TextDocumentUri $uri, private ByteOffset $offset)
    {
    }
    public static function fromPathAndOffset(string $string, int $int) : Location
    {
        return new self(TextDocumentUri::fromString($string), ByteOffset::fromInt($int));
    }
    public function uri() : TextDocumentUri
    {
        return $this->uri;
    }
    public function offset() : ByteOffset
    {
        return $this->offset;
    }
}
\class_alias('Phpactor202301\\Phpactor\\TextDocument\\Location', 'Phpactor\\TextDocument\\Location', \false);