<?php

namespace Phpactor202301\Phpactor\Extension\ReferenceFinderRpc\Tests\Unit\Handler;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\ReferenceFinderRpc\Handler\GotoTypeHandler;
use Phpactor202301\Phpactor\Extension\Rpc\Response\OpenFileResponse;
use Phpactor202301\Phpactor\Extension\Rpc\Test\HandlerTester;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocation;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocations;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocator;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Location;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\MixedType;
class GotoTypeHandlerTest extends TestCase
{
    const EXAMPLE_SOURCE = 'some source file';
    const EXAMPLE_OFFSET = 1234;
    const EXAMPLE_PATH = '/some/path.php';
    public function testGotoType() : void
    {
        $location = $this->create()->handle('goto_type', ['source' => self::EXAMPLE_SOURCE, 'offset' => self::EXAMPLE_OFFSET, 'path' => self::EXAMPLE_PATH, 'target' => OpenFileResponse::TARGET_HORIZONTAL_SPLIT]);
        $this->assertInstanceOf(OpenFileResponse::class, $location);
        $this->assertEquals(self::EXAMPLE_PATH, $location->path());
        $this->assertEquals(OpenFileResponse::TARGET_HORIZONTAL_SPLIT, $location->target());
    }
    public function create() : HandlerTester
    {
        $locator = new class implements TypeLocator
        {
            public function locateTypes(TextDocument $document, ByteOffset $byteOffset) : TypeLocations
            {
                return new TypeLocations([new TypeLocation(new MixedType(), new Location($document->uri(), $byteOffset))]);
            }
        };
        return new HandlerTester(new GotoTypeHandler($locator));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ReferenceFinderRpc\\Tests\\Unit\\Handler\\GotoTypeHandlerTest', 'Phpactor\\Extension\\ReferenceFinderRpc\\Tests\\Unit\\Handler\\GotoTypeHandlerTest', \false);
