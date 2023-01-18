<?php

namespace Phpactor202301\Phpactor\WorseReferenceFinder;

use Phpactor202301\Phpactor\ReferenceFinder\DefinitionLocator;
use Phpactor202301\Phpactor\ReferenceFinder\Exception\CouldNotLocateDefinition;
use Phpactor202301\Phpactor\ReferenceFinder\PotentialLocation;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocation;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocations;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Location;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use function assert;
class TolerantVariableDefintionLocator implements DefinitionLocator
{
    public function __construct(private TolerantVariableReferenceFinder $finder)
    {
    }
    public function locateDefinition(TextDocument $document, ByteOffset $byteOffset) : TypeLocations
    {
        foreach ($this->finder->findReferences($document, $byteOffset) as $reference) {
            assert($reference instanceof PotentialLocation);
            return TypeLocations::forLocation(new TypeLocation(
                // we don't have the type info of the variable here, but
                // there'll only be one so we don't need it.
                TypeFactory::undefined(),
                new Location($reference->location()->uri(), $reference->location()->offset())
            ));
        }
        throw new CouldNotLocateDefinition('Could not locate any references to variable');
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReferenceFinder\\TolerantVariableDefintionLocator', 'Phpactor\\WorseReferenceFinder\\TolerantVariableDefintionLocator', \false);
