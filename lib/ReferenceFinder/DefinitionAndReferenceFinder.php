<?php

namespace Phpactor202301\Phpactor\ReferenceFinder;

use Generator;
use Phpactor202301\Phpactor\ReferenceFinder\Exception\CouldNotLocateDefinition;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class DefinitionAndReferenceFinder implements ReferenceFinder
{
    public function __construct(private DefinitionLocator $locator, private ReferenceFinder $referenceFinder)
    {
    }
    public function findReferences(TextDocument $document, ByteOffset $byteOffset) : Generator
    {
        try {
            $location = $this->locator->locateDefinition($document, $byteOffset);
            (yield PotentialLocation::surely($location->first()->location()));
        } catch (CouldNotLocateDefinition) {
        }
        foreach ($this->referenceFinder->findReferences($document, $byteOffset) as $reference) {
            (yield $reference);
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\ReferenceFinder\\DefinitionAndReferenceFinder', 'Phpactor\\ReferenceFinder\\DefinitionAndReferenceFinder', \false);
