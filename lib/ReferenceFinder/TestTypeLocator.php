<?php

namespace Phpactor\ReferenceFinder;

use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\TextDocument;
class TestTypeLocator implements \Phpactor\ReferenceFinder\TypeLocator
{
    public function __construct(private \Phpactor\ReferenceFinder\TypeLocations $locations)
    {
    }
    public function locateTypes(TextDocument $document, ByteOffset $byteOffset) : \Phpactor\ReferenceFinder\TypeLocations
    {
        return $this->locations;
    }
}
