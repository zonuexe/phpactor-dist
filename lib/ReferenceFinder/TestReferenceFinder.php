<?php

namespace Phpactor202301\Phpactor\ReferenceFinder;

use Generator;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class TestReferenceFinder implements ReferenceFinder
{
    /**
     * @var PotentialLocation[]
     */
    private array $locations;
    public function __construct(PotentialLocation ...$locations)
    {
        $this->locations = $locations;
    }
    public function findReferences(TextDocument $document, ByteOffset $byteOffset) : Generator
    {
        foreach ($this->locations as $location) {
            (yield $location);
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\ReferenceFinder\\TestReferenceFinder', 'Phpactor\\ReferenceFinder\\TestReferenceFinder', \false);
