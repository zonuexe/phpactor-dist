<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\Tests\Unit\Handler;

use Phpactor202301\Phpactor\Extension\LanguageServerBridge\TextDocument\WorkspaceTextDocumentLocator;
use Phpactor202301\Phpactor\LanguageServerProtocol\Location as LspLocation;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\LocationConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\Handler\GotoImplementationHandler;
use Phpactor202301\Phpactor\LanguageServer\LanguageServerTesterBuilder;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use Phpactor202301\Phpactor\ReferenceFinder\ClassImplementationFinder;
use Phpactor202301\Phpactor\TestUtils\PHPUnit\TestCase;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Location;
use Phpactor202301\Phpactor\TextDocument\Locations;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class GotoImplementationHandlerTest extends TestCase
{
    const EXAMPLE_URI = 'file:///test.php';
    const EXAMPLE_TEXT = 'hello';
    /**
     * @var ObjectProphecy|ClassImplementationFinder
     */
    private $finder;
    protected function setUp() : void
    {
        $this->finder = $this->prophesize(ClassImplementationFinder::class);
    }
    public function testGoesToImplementation() : void
    {
        $document = TextDocumentBuilder::create(self::EXAMPLE_TEXT)->language('php')->uri(self::EXAMPLE_URI)->build();
        $this->finder->findImplementations($document, ByteOffset::fromInt(0))->willReturn(new Locations([new Location($document->uri(), ByteOffset::fromInt(2))]));
        $builder = LanguageServerTesterBuilder::create();
        $tester = $builder->addHandler(new GotoImplementationHandler($builder->workspace(), $this->finder->reveal(), new LocationConverter(new WorkspaceTextDocumentLocator($builder->workspace()))))->build();
        $tester->textDocument()->open(self::EXAMPLE_URI, self::EXAMPLE_TEXT);
        $response = $tester->requestAndWait('textDocument/implementation', ['textDocument' => ProtocolFactory::textDocumentIdentifier(self::EXAMPLE_URI), 'position' => ProtocolFactory::position(0, 0)]);
        $locations = $response->result;
        $this->assertIsArray($locations);
        $this->assertCount(1, $locations);
        $lspLocation = \reset($locations);
        $this->assertInstanceOf(LspLocation::class, $lspLocation);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerReferenceFinder\\Tests\\Unit\\Handler\\GotoImplementationHandlerTest', 'Phpactor\\Extension\\LanguageServerReferenceFinder\\Tests\\Unit\\Handler\\GotoImplementationHandlerTest', \false);
