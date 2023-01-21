<?php

namespace Phpactor\ReferenceFinder;

use Phpactor\ReferenceFinder\Exception\CouldNotLocateDefinition;
use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\Location;
use Phpactor\TextDocument\TextDocument;
use Phpactor\WorseReflection\Core\Type;
class TestDefinitionLocator implements \Phpactor\ReferenceFinder\DefinitionLocator
{
    public function __construct(private ?\Phpactor\ReferenceFinder\TypeLocations $location)
    {
    }
    public static function fromSingleLocation(Type $type, ?Location $location) : self
    {
        if (null === $location) {
            return new self(null);
        }
        return new self(new \Phpactor\ReferenceFinder\TypeLocations([new \Phpactor\ReferenceFinder\TypeLocation($type, $location)]));
    }
    public function locateDefinition(TextDocument $document, ByteOffset $byteOffset) : \Phpactor\ReferenceFinder\TypeLocations
    {
        if (null === $this->location) {
            throw new CouldNotLocateDefinition('Definition not found');
        }
        return $this->location;
    }
}
