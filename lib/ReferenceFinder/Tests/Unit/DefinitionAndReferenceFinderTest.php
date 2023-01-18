<?php

namespace Phpactor202301\Phpactor\ReferenceFinder\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\ReferenceFinder\DefinitionAndReferenceFinder;
use Phpactor202301\Phpactor\ReferenceFinder\DefinitionLocation;
use Phpactor202301\Phpactor\ReferenceFinder\PotentialLocation;
use Phpactor202301\Phpactor\ReferenceFinder\TestDefinitionLocator;
use Phpactor202301\Phpactor\ReferenceFinder\TestReferenceFinder;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Location;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use function iterator_to_array;
class DefinitionAndReferenceFinderTest extends TestCase
{
    public function testReturnsBothDefinitionAndReference() : void
    {
        $finder = new DefinitionAndReferenceFinder(TestDefinitionLocator::fromSingleLocation(TypeFactory::unknown(), new DefinitionLocation(TextDocumentUri::fromString('/path'), ByteOffset::fromInt(1))), new TestReferenceFinder(PotentialLocation::surely(Location::fromPathAndOffset('/path', 2))));
        $document = TextDocumentBuilder::create('asd')->build();
        self::assertCount(2, iterator_to_array($finder->findReferences($document, ByteOffset::fromInt(1))));
    }
    public function testReturnsReferenceIfDefinitionNotFound() : void
    {
        $finder = new DefinitionAndReferenceFinder(new TestDefinitionLocator(null), new TestReferenceFinder(PotentialLocation::surely(Location::fromPathAndOffset('/path', 2))));
        $document = TextDocumentBuilder::create('asd')->build();
        self::assertCount(1, iterator_to_array($finder->findReferences($document, ByteOffset::fromInt(1))));
    }
}
\class_alias('Phpactor202301\\Phpactor\\ReferenceFinder\\Tests\\Unit\\DefinitionAndReferenceFinderTest', 'Phpactor\\ReferenceFinder\\Tests\\Unit\\DefinitionAndReferenceFinderTest', \false);
