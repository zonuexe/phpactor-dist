<?php

namespace Phpactor202301\Phpactor\ReferenceFinder;

use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class TestTypeLocator implements TypeLocator
{
    public function __construct(private TypeLocations $locations)
    {
    }
    public function locateTypes(TextDocument $document, ByteOffset $byteOffset) : TypeLocations
    {
        return $this->locations;
    }
}
\class_alias('Phpactor202301\\Phpactor\\ReferenceFinder\\TestTypeLocator', 'Phpactor\\ReferenceFinder\\TestTypeLocator', \false);
