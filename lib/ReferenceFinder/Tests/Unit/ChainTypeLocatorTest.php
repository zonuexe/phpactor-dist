<?php

namespace Phpactor202301\Phpactor\ReferenceFinder\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\ReferenceFinder\ChainTypeLocator;
use Phpactor202301\Phpactor\ReferenceFinder\Exception\CouldNotLocateType;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocation;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocations;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocator;
use Phpactor202301\Phpactor\ReferenceFinder\Exception\UnsupportedDocument;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Location;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\MixedType;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class ChainTypeLocatorTest extends TestCase
{
    use ProphecyTrait;
    /**
     * @var ObjectProphecy|TypeLocator
     */
    private $locator1;
    /**
     * @var ObjectProphecy|TypeLocator
     */
    private $locator2;
    private TextDocument $document;
    private ByteOffset $offset;
    public function setUp() : void
    {
        $this->locator1 = $this->prophesize(TypeLocator::class);
        $this->locator2 = $this->prophesize(TypeLocator::class);
        $this->document = TextDocumentBuilder::create('<?php ')->build();
        $this->offset = ByteOffset::fromInt(1234);
    }
    public function testProvidesAggregatedLocations() : void
    {
        $locator = new ChainTypeLocator([$this->locator1->reveal(), $this->locator2->reveal()]);
        $location1 = $this->createLocation();
        $this->locator1->locateTypes($this->document, $this->offset)->willReturn($this->createLocations($location1));
        $location2 = $this->createLocation();
        $this->locator2->locateTypes($this->document, $this->offset)->willReturn($this->createLocations($location2));
        $location = $locator->locateTypes($this->document, $this->offset);
        $this->assertSame($location->first()->location(), $location1);
    }
    public function testExceptionWhenTypeNotFound() : void
    {
        $this->expectException(CouldNotLocateType::class);
        $this->expectExceptionMessage('No');
        $locator = new ChainTypeLocator([$this->locator1->reveal()]);
        $this->locator1->locateTypes($this->document, $this->offset)->willThrow(new CouldNotLocateType('No'));
        $locator->locateTypes($this->document, $this->offset);
    }
    public function testExceptionWhenTypeNotSupported() : void
    {
        $this->expectException(CouldNotLocateType::class);
        $this->expectExceptionMessage('Not supported');
        $locator = new ChainTypeLocator([$this->locator1->reveal()]);
        $this->locator1->locateTypes($this->document, $this->offset)->willThrow(new UnsupportedDocument('Not supported'));
        $locator->locateTypes($this->document, $this->offset);
    }
    private function createLocation() : Location
    {
        return new Location(TextDocumentUri::fromString('/path/to.php'), ByteOffset::fromInt(1234));
    }
    private function createLocations(Location $location1) : TypeLocations
    {
        return new TypeLocations([new TypeLocation(new MixedType(), $location1)]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\ReferenceFinder\\Tests\\Unit\\ChainTypeLocatorTest', 'Phpactor\\ReferenceFinder\\Tests\\Unit\\ChainTypeLocatorTest', \false);
