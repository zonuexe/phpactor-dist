<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\Tests\Unit\Handler;

use Phpactor202301\Phpactor\Extension\LanguageServerBridge\TextDocument\WorkspaceTextDocumentLocator;
use Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\Handler\TypeDefinitionHandler;
use Phpactor202301\Phpactor\LanguageServerProtocol\Location;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\LocationConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\MessageActionItem;
use Phpactor202301\Phpactor\LanguageServerProtocol\TypeDefinitionRequest;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ResponseWatcher\TestResponseWatcher;
use Phpactor202301\Phpactor\LanguageServer\LanguageServerTesterBuilder;
use Phpactor202301\Phpactor\LanguageServer\Test\LanguageServerTester;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use Phpactor202301\Phpactor\ReferenceFinder\TestTypeLocator;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocation;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocations;
use Phpactor202301\Phpactor\TestUtils\PHPUnit\TestCase;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Location as PhpactorLocation;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use function Phpactor202301\Amp\Promise\wait;
class TypeDefinitionHandlerTest extends TestCase
{
    const EXAMPLE_URI = 'file:///test';
    const EXAMPLE_TEXT = 'hello';
    public function testGoesToSingleType() : void
    {
        $locations = [new TypeLocation(TypeFactory::class('Foobar'), new PhpactorLocation(TextDocumentUri::fromString(self::EXAMPLE_URI), ByteOffset::fromInt(2)))];
        [$tester, $_] = $this->createTester($locations);
        $response = $tester->requestAndWait(TypeDefinitionRequest::METHOD, ['textDocument' => ProtocolFactory::textDocumentIdentifier(self::EXAMPLE_URI), 'position' => ProtocolFactory::position(0, 0)]);
        $location = $response->result;
        $this->assertInstanceOf(Location::class, $location);
        $this->assertEquals(self::EXAMPLE_URI, $location->uri);
        $this->assertEquals(2, $location->range->start->character);
    }
    public function testGoesToMultipleTypes() : void
    {
        $locations = [new TypeLocation(TypeFactory::class('Foobar'), new PhpactorLocation(TextDocumentUri::fromString(self::EXAMPLE_URI), ByteOffset::fromInt(2))), new TypeLocation(TypeFactory::class('Barfoo'), new PhpactorLocation(TextDocumentUri::fromString(self::EXAMPLE_URI), ByteOffset::fromInt(2)))];
        [$tester, $watcher] = $this->createTester($locations);
        $promise = $tester->request(TypeDefinitionRequest::METHOD, ['textDocument' => ProtocolFactory::textDocumentIdentifier(self::EXAMPLE_URI), 'position' => ProtocolFactory::position(0, 0)]);
        $watcher->resolveLastResponse(new MessageActionItem('Foobar'));
        $response = wait($promise);
        $location = $response->result;
        $this->assertInstanceOf(Location::class, $location);
        $this->assertEquals(self::EXAMPLE_URI, $location->uri);
        $this->assertEquals(2, $location->range->start->character);
    }
    /**
     * @return array{LanguageServerTester,TestResponseWatcher}
     * @param TypeLocation[] $locations
     */
    private function createTester(array $locations) : array
    {
        $document = TextDocumentBuilder::create(self::EXAMPLE_TEXT)->uri(self::EXAMPLE_URI)->build();
        $builder = LanguageServerTesterBuilder::create();
        $tester = $builder->addHandler(new TypeDefinitionHandler($builder->workspace(), new TestTypeLocator(new TypeLocations($locations)), new LocationConverter(new WorkspaceTextDocumentLocator($builder->workspace())), $builder->clientApi()))->build();
        $tester->textDocument()->open(self::EXAMPLE_URI, self::EXAMPLE_TEXT);
        return [$tester, $builder->responseWatcher()];
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerReferenceFinder\\Tests\\Unit\\Handler\\TypeDefinitionHandlerTest', 'Phpactor\\Extension\\LanguageServerReferenceFinder\\Tests\\Unit\\Handler\\TypeDefinitionHandlerTest', \false);
