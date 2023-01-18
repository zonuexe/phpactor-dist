<?php

namespace Phpactor202301\Phpactor\Extension\ReferenceFinderRpc\Tests\Unit\Handler;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\ReferenceFinderRpc\Handler\GotoImplementationHandler;
use Phpactor202301\Phpactor\Extension\Rpc\Response\FileReferencesResponse;
use Phpactor202301\Phpactor\Extension\Rpc\Response\OpenFileResponse;
use Phpactor202301\Phpactor\Extension\Rpc\Test\HandlerTester;
use Phpactor202301\Phpactor\ReferenceFinder\ClassImplementationFinder;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Location;
use Phpactor202301\Phpactor\TextDocument\Locations;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class GotoImplementationHandlerTest extends TestCase
{
    const EXAMPLE_SOURCE = 'some source file';
    const EXAMPLE_OFFSET = 1234;
    const EXAMPLE_PATH = '/some/path.php';
    public function testGotoSingleImplementation() : void
    {
        $location = $this->create([Location::fromPathAndOffset(self::EXAMPLE_PATH, 10)])->handle('goto_implementation', ['source' => self::EXAMPLE_SOURCE, 'offset' => self::EXAMPLE_OFFSET, 'path' => self::EXAMPLE_PATH, 'target' => OpenFileResponse::TARGET_HORIZONTAL_SPLIT]);
        $this->assertInstanceOf(OpenFileResponse::class, $location);
        $this->assertEquals(self::EXAMPLE_PATH, $location->path());
        $this->assertEquals(OpenFileResponse::TARGET_HORIZONTAL_SPLIT, $location->target());
    }
    public function testSelectFromMultiple() : void
    {
        $response = $this->create([Location::fromPathAndOffset(__FILE__, 20), Location::fromPathAndOffset(__FILE__, 40)])->handle('goto_implementation', ['source' => self::EXAMPLE_SOURCE, 'offset' => self::EXAMPLE_OFFSET, 'path' => self::EXAMPLE_PATH, 'target' => OpenFileResponse::TARGET_HORIZONTAL_SPLIT]);
        $this->assertInstanceOf(FileReferencesResponse::class, $response);
    }
    /**
     * @param Location[] $locations
     */
    public function create(array $locations) : HandlerTester
    {
        $locator = new class($locations) implements ClassImplementationFinder
        {
            /**
             * @param Location[] $locations
             */
            public function __construct(private array $locations)
            {
            }
            public function findImplementations(TextDocument $document, ByteOffset $byteOffset, bool $includeDefinition = \false) : Locations
            {
                return new Locations($this->locations);
            }
        };
        return new HandlerTester(new GotoImplementationHandler($locator));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ReferenceFinderRpc\\Tests\\Unit\\Handler\\GotoImplementationHandlerTest', 'Phpactor\\Extension\\ReferenceFinderRpc\\Tests\\Unit\\Handler\\GotoImplementationHandlerTest', \false);
