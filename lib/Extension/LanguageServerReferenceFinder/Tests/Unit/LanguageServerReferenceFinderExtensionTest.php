<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\Tests\Unit;

use Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\Tests\Extension\TestIndexerExtension;
use Phpactor202301\Phpactor\LanguageServerProtocol\ReferenceContext;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentIdentifier;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\LanguageServerBridgeExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\LanguageServerReferenceFinderExtension;
use Phpactor202301\Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\ReferenceFinder\ReferenceFinderExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\LanguageServer\LanguageServerBuilder;
use Phpactor202301\Phpactor\LanguageServer\Test\LanguageServerTester;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use Phpactor202301\Phpactor\TestUtils\Workspace;
use function Phpactor202301\Safe\file_get_contents;
class LanguageServerReferenceFinderExtensionTest extends TestCase
{
    protected function setUp() : void
    {
        $this->workspace()->reset();
    }
    public function testDefinition() : void
    {
        $tester = $this->createTester();
        $tester->textDocument()->open(__FILE__, file_get_contents(__FILE__));
        $response = $tester->requestAndWait('textDocument/definition', ['textDocument' => new TextDocumentIdentifier(__FILE__), 'position' => []]);
        $this->assertNull($response->result, 'Definition was not found');
    }
    public function testTypeDefinition() : void
    {
        $tester = $this->createTester();
        $tester->textDocument()->open(__FILE__, file_get_contents(__FILE__));
        $response = $tester->requestAndWait('textDocument/typeDefinition', ['textDocument' => new TextDocumentIdentifier(__FILE__), 'position' => []]);
        $this->assertNull($response->result, 'Type was not found');
    }
    public function testReferenceFinder() : void
    {
        $tester = $this->createTester();
        $tester->textDocument()->open(__FILE__, file_get_contents(__FILE__));
        $response = $tester->requestAndWait('textDocument/references', ['textDocument' => new TextDocumentIdentifier(__FILE__), 'position' => ['line' => 0, 'character' => 0], 'context' => new ReferenceContext(\false)]);
        $tester->assertSuccess($response);
        $this->assertIsArray($response->result, 'Returned empty references');
    }
    protected function workspace() : Workspace
    {
        return Workspace::create(__DIR__ . '/../Workspace');
    }
    private function createTester() : LanguageServerTester
    {
        $container = PhpactorContainer::fromExtensions([LoggingExtension::class, LanguageServerExtension::class, LanguageServerReferenceFinderExtension::class, ReferenceFinderExtension::class, FilePathResolverExtension::class, LanguageServerBridgeExtension::class, TestIndexerExtension::class]);
        $builder = $container->get(LanguageServerBuilder::class);
        $this->assertInstanceOf(LanguageServerBuilder::class, $builder);
        return $builder->tester(ProtocolFactory::initializeParams(__DIR__));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerReferenceFinder\\Tests\\Unit\\LanguageServerReferenceFinderExtensionTest', 'Phpactor\\Extension\\LanguageServerReferenceFinder\\Tests\\Unit\\LanguageServerReferenceFinderExtensionTest', \false);
