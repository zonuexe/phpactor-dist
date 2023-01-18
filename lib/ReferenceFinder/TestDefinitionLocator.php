<?php

namespace Phpactor202301\Phpactor\ReferenceFinder;

use Phpactor202301\Phpactor\ReferenceFinder\Exception\CouldNotLocateDefinition;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Location;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
class TestDefinitionLocator implements DefinitionLocator
{
    public function __construct(private ?TypeLocations $location)
    {
    }
    public static function fromSingleLocation(Type $type, ?Location $location) : self
    {
        if (null === $location) {
            return new self(null);
        }
        return new self(new TypeLocations([new TypeLocation($type, $location)]));
    }
    public function locateDefinition(TextDocument $document, ByteOffset $byteOffset) : TypeLocations
    {
        if (null === $this->location) {
            throw new CouldNotLocateDefinition('Definition not found');
        }
        return $this->location;
    }
}
\class_alias('Phpactor202301\\Phpactor\\ReferenceFinder\\TestDefinitionLocator', 'Phpactor\\ReferenceFinder\\TestDefinitionLocator', \false);
