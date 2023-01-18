<?php

namespace Phpactor202301\Phpactor\ReferenceFinder;

use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Locations;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
final class ChainImplementationFinder implements ClassImplementationFinder
{
    /**
     * @var ClassImplementationFinder[]
     */
    private array $finders = [];
    /**
     * @param ClassImplementationFinder[] $finders
     */
    public function __construct(array $finders)
    {
        foreach ($finders as $finder) {
            $this->add($finder);
        }
    }
    public function findImplementations(TextDocument $document, ByteOffset $byteOffset, bool $includeDefinition = \false) : Locations
    {
        $messages = [];
        $locations = [];
        foreach ($this->finders as $finder) {
            $locations = \array_merge($locations, \iterator_to_array($finder->findImplementations($document, $byteOffset, $includeDefinition)));
        }
        return new Locations($locations);
    }
    private function add(ClassImplementationFinder $finder) : void
    {
        $this->finders[] = $finder;
    }
}
\class_alias('Phpactor202301\\Phpactor\\ReferenceFinder\\ChainImplementationFinder', 'Phpactor\\ReferenceFinder\\ChainImplementationFinder', \false);
