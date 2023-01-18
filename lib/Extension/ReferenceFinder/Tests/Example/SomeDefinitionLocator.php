<?php

namespace Phpactor202301\Phpactor\Extension\ReferenceFinder\Tests\Example;

use Phpactor202301\Phpactor\ReferenceFinder\DefinitionLocator;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocation;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocations;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Location;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
class SomeDefinitionLocator implements DefinitionLocator
{
    const EXAMPLE_PATH = '/path/to.php';
    const EXAMPLE_OFFSET = 666;
    public function locateDefinition(TextDocument $document, ByteOffset $byteOffset) : TypeLocations
    {
        return new TypeLocations([new TypeLocation(TypeFactory::mixed(), new Location(TextDocumentUri::fromString(self::EXAMPLE_PATH), ByteOffset::fromInt(self::EXAMPLE_OFFSET)))]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ReferenceFinder\\Tests\\Example\\SomeDefinitionLocator', 'Phpactor\\Extension\\ReferenceFinder\\Tests\\Example\\SomeDefinitionLocator', \false);
