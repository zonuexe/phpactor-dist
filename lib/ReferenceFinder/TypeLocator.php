<?php

namespace Phpactor202301\Phpactor\ReferenceFinder;

use Phpactor202301\Phpactor\ReferenceFinder\Exception\CouldNotLocateType;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Location;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
interface TypeLocator
{
    /**
     * Provide the Location (URI and byte offset) for the text under the
     * cursor.
     *
     * If this locator cannot provide a location it MUST throw a
     * CouldNotLocateType exception.
     */
    public function locateTypes(TextDocument $document, ByteOffset $byteOffset) : TypeLocations;
}
\class_alias('Phpactor202301\\Phpactor\\ReferenceFinder\\TypeLocator', 'Phpactor\\ReferenceFinder\\TypeLocator', \false);
