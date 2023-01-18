<?php

namespace Phpactor202301\Phpactor\ReferenceFinder;

use Phpactor202301\Phpactor\ReferenceFinder\Exception\CouldNotLocateDefinition;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
interface DefinitionLocator
{
    /**
     * Provide the DefinitionLocation (URI and byte offset) for the text under
     * the cursor.
     *
     * If this locator cannot provide a definition it MUST throw a
     * CouldNotLocateDefinition exception.
     *
     * @throws CouldNotLocateDefinition
     */
    public function locateDefinition(TextDocument $document, ByteOffset $byteOffset) : TypeLocations;
}
\class_alias('Phpactor202301\\Phpactor\\ReferenceFinder\\DefinitionLocator', 'Phpactor\\ReferenceFinder\\DefinitionLocator', \false);
