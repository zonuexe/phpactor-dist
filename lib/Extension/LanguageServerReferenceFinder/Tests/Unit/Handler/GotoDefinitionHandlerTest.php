<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\Tests\Unit\Handler;

use Phpactor202301\Phpactor\Extension\LanguageServerBridge\TextDocument\WorkspaceTextDocumentLocator;
use Phpactor202301\Phpactor\LanguageServerProtocol\DefinitionRequest;
use Phpactor202301\Phpactor\LanguageServerProtocol\Location;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\LocationConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\Handler\GotoDefinitionHandler;
use Phpactor202301\Phpactor\LanguageServerProtocol\MessageActionItem;
use Phpactor202301\Phpactor\LanguageServer\LanguageServerTesterBuilder;
use Phpactor202301\Phpactor\LanguageServer\Test\LanguageServerTester;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use Phpactor202301\Phpactor\ReferenceFinder\DefinitionLocation;
use Phpactor202301\Phpactor\ReferenceFinder\TestDefinitionLocator;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocation;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocations;
use Phpactor202301\Phpactor\TestUtils\PHPUnit\TestCase;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Location as PhpactorLocation;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use function Phpactor202301\Amp\Promise\wait;
class GotoDefinitionHandlerTest extends TestCase
{
    const EXAMPLE_URI = 'file:///test';
    const EXAMPLE_TEXT = 'hello';
    public function testGoesToDefinition() : void
    {
        $document = TextDocumentBuilder::create(self::EXAMPLE_TEXT)->uri(self::EXAMPLE_URI)->build();
        $locations = [new TypeLocation(TypeFactory::class('Foo'), new DefinitionLocation($document->uri(), ByteOffset::fromInt(2)))];
        [$tester, $_] = $this->createTester($locations);
        $response = $tester->requestAndWait(DefinitionRequest::METHOD, ['textDocument' => ProtocolFactory::textDocumentIdentifier(self::EXAMPLE_URI), 'position' => ProtocolFactory::position(0, 0)]);
        $location = $response->result;
        $this->assertInstanceOf(Location::class, $location);
        $this->assertEquals(self::EXAMPLE_URI, $location->uri);
        $this->assertEquals(2, $location->range->start->character);
    }
    public function testPresentChoiceIfAmbiguous() : void
    {
        $locations = [new TypeLocation(TypeFactory::class('Foobar'), new PhpactorLocation(TextDocumentUri::fromString(self::EXAMPLE_URI), ByteOffset::fromInt(2))), new TypeLocation(TypeFactory::class('Barfoo'), new PhpactorLocation(TextDocumentUri::fromString(self::EXAMPLE_URI), ByteOffset::fromInt(2)))];
        [$tester, $builder] = $this->createTester($locations);
        $watcher = $builder->responseWatcher();
        $promise = $tester->request(DefinitionRequest::METHOD, ['textDocument' => ProtocolFactory::textDocumentIdentifier(self::EXAMPLE_URI), 'position' => ProtocolFactory::position(0, 0)]);
        $watcher->resolveLastResponse(new MessageActionItem('Foobar'));
        $response = wait($promise);
        $location = $response->result;
        $this->assertInstanceOf(Location::class, $location);
        $this->assertEquals(self::EXAMPLE_URI, $location->uri);
        $this->assertEquals(2, $location->range->start->character);
    }
    /**
     * @return array{LanguageServerTester,LanguageServerTesterBuilder}
     * @param TypeLocation[] $locations
     */
    private function createTester(array $locations) : array
    {
        $builder = LanguageServerTesterBuilder::create();
        $tester = $builder->addHandler(new GotoDefinitionHandler($builder->workspace(), new TestDefinitionLocator(new TypeLocations($locations)), new LocationConverter(new WorkspaceTextDocumentLocator($builder->workspace())), $builder->clientApi()))->build();
        $tester->textDocument()->open(self::EXAMPLE_URI, self::EXAMPLE_TEXT);
        return [$tester, $builder];
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerReferenceFinder\\Tests\\Unit\\Handler\\GotoDefinitionHandlerTest', 'Phpactor\\Extension\\LanguageServerReferenceFinder\\Tests\\Unit\\Handler\\GotoDefinitionHandlerTest', \false);
