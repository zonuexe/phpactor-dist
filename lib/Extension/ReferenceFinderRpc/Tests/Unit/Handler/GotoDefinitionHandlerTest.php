<?php

namespace Phpactor202301\Phpactor\Extension\ReferenceFinderRpc\Tests\Unit\Handler;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\ReferenceFinderRpc\Handler\GotoDefinitionHandler;
use Phpactor202301\Phpactor\Extension\Rpc\Response\OpenFileResponse;
use Phpactor202301\Phpactor\Extension\Rpc\Test\HandlerTester;
use Phpactor202301\Phpactor\ReferenceFinder\DefinitionLocation;
use Phpactor202301\Phpactor\ReferenceFinder\TestDefinitionLocator;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
class GotoDefinitionHandlerTest extends TestCase
{
    const EXAMPLE_SOURCE = 'some source file';
    const EXAMPLE_OFFSET = 1234;
    const EXAMPLE_PATH = '/some/path.php';
    public function testGotoDefinition() : void
    {
        $location = $this->create()->handle('goto_definition', ['source' => self::EXAMPLE_SOURCE, 'offset' => self::EXAMPLE_OFFSET, 'path' => self::EXAMPLE_PATH, 'target' => OpenFileResponse::TARGET_HORIZONTAL_SPLIT]);
        $this->assertInstanceOf(OpenFileResponse::class, $location);
        $this->assertEquals(self::EXAMPLE_PATH, $location->path());
        $this->assertEquals(OpenFileResponse::TARGET_HORIZONTAL_SPLIT, $location->target());
    }
    public function create() : HandlerTester
    {
        $location = new DefinitionLocation(TextDocumentUri::fromString(self::EXAMPLE_PATH), ByteOffset::fromInt(1));
        return new HandlerTester(new GotoDefinitionHandler(TestDefinitionLocator::fromSingleLocation(TypeFactory::unknown(), $location)));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ReferenceFinderRpc\\Tests\\Unit\\Handler\\GotoDefinitionHandlerTest', 'Phpactor\\Extension\\ReferenceFinderRpc\\Tests\\Unit\\Handler\\GotoDefinitionHandlerTest', \false);
