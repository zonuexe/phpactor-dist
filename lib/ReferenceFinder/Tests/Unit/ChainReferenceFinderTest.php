<?php

namespace Phpactor202301\Phpactor\ReferenceFinder\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\ReferenceFinder\ChainReferenceFinder;
use Phpactor202301\Phpactor\ReferenceFinder\ClassReferenceFinder;
use Phpactor202301\Phpactor\ReferenceFinder\ReferenceFinder;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Location;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class ChainReferenceFinderTest extends TestCase
{
    use ProphecyTrait;
    /**
     * @var ObjectProphecy|ClassReferenceFinder
     */
    private $locator1;
    /**
     * @var ObjectProphecy|ClassReferenceFinder
     */
    private $locator2;
    private TextDocument $document;
    private ByteOffset $offset;
    public function setUp() : void
    {
        $this->locator1 = $this->prophesize(ReferenceFinder::class);
        $this->locator2 = $this->prophesize(ReferenceFinder::class);
        $this->document = TextDocumentBuilder::create('<?php ')->build();
        $this->offset = ByteOffset::fromInt(1234);
    }
    public function testProvidesAggregateLocations() : void
    {
        $locator = new ChainReferenceFinder([$this->locator1->reveal(), $this->locator2->reveal()]);
        $location1 = $this->createLocation();
        $this->locator1->findReferences($this->document, $this->offset)->willYield([$location1]);
        $location2 = $this->createLocation();
        $this->locator2->findReferences($this->document, $this->offset)->willYield([$location2]);
        $locations = [];
        foreach ($locator->findReferences($this->document, $this->offset) as $location) {
            $locations[] = $location;
        }
        $this->assertEquals([$location1, $location2], $locations);
    }
    private function createLocation() : Location
    {
        return new Location(TextDocumentUri::fromString('/path/to.php'), ByteOffset::fromInt(1234));
    }
}
\class_alias('Phpactor202301\\Phpactor\\ReferenceFinder\\Tests\\Unit\\ChainReferenceFinderTest', 'Phpactor\\ReferenceFinder\\Tests\\Unit\\ChainReferenceFinderTest', \false);
