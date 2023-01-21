<?php

namespace Phpactor\ReferenceFinder;

use Generator;
use Phpactor\ReferenceFinder\Exception\CouldNotLocateDefinition;
use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\TextDocument;
class DefinitionAndReferenceFinder implements \Phpactor\ReferenceFinder\ReferenceFinder
{
    public function __construct(private \Phpactor\ReferenceFinder\DefinitionLocator $locator, private \Phpactor\ReferenceFinder\ReferenceFinder $referenceFinder)
    {
    }
    public function findReferences(TextDocument $document, ByteOffset $byteOffset) : Generator
    {
        try {
            $location = $this->locator->locateDefinition($document, $byteOffset);
            (yield \Phpactor\ReferenceFinder\PotentialLocation::surely($location->first()->location()));
        } catch (CouldNotLocateDefinition) {
        }
        foreach ($this->referenceFinder->findReferences($document, $byteOffset) as $reference) {
            (yield $reference);
        }
    }
}
