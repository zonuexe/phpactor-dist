<?php

namespace Phpactor202301\Phpactor\Rename\Model\ReferenceFinder;

use Phpactor202301\Phpactor\ReferenceFinder\PotentialLocation;
use Phpactor202301\Phpactor\ReferenceFinder\ReferenceFinder;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Generator;
class PredefinedReferenceFinderFoo implements ReferenceFinder
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
\class_alias('Phpactor202301\\Phpactor\\Rename\\Model\\ReferenceFinder\\PredefinedReferenceFinderFoo', 'Phpactor\\Rename\\Model\\ReferenceFinder\\PredefinedReferenceFinderFoo', \false);
