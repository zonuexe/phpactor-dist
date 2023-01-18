<?php

namespace Phpactor202301\Phpactor\Extension\ReferenceFinder\Tests\Example;

use Phpactor202301\Phpactor\ReferenceFinder\TypeLocation;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocations;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocator;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Location;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\MixedType;
class SomeTypeLocator implements TypeLocator
{
    const EXAMPLE_OFFSET = 1;
    const EXAMPLE_PATH = '/foobar';
    public function locateTypes(TextDocument $document, ByteOffset $byteOffset) : TypeLocations
    {
        return new TypeLocations([new TypeLocation(new MixedType(), new Location(TextDocumentUri::fromString(self::EXAMPLE_PATH), ByteOffset::fromInt(self::EXAMPLE_OFFSET)))]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ReferenceFinder\\Tests\\Example\\SomeTypeLocator', 'Phpactor\\Extension\\ReferenceFinder\\Tests\\Example\\SomeTypeLocator', \false);
