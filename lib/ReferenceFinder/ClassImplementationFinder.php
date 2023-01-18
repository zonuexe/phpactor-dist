<?php

namespace Phpactor202301\Phpactor\ReferenceFinder;

use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Locations;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
interface ClassImplementationFinder
{
    /**
     * Find implementations of the symbol under the given byte offset.
     *
     * If an interface FQN, then return location of classes which implement the
     * interface.
     *
     * If a call for method on an interface, then return location list of the class
     * implementations but with an offset position of the method.
     */
    public function findImplementations(TextDocument $document, ByteOffset $byteOffset, bool $includeDefinition = \false) : Locations;
}
\class_alias('Phpactor202301\\Phpactor\\ReferenceFinder\\ClassImplementationFinder', 'Phpactor\\ReferenceFinder\\ClassImplementationFinder', \false);
