<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerPsalm\Tests\DiagnosticProvider;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\LanguageServerPsalm\DiagnosticProvider\PsalmDiagnosticProvider;
use Phpactor202301\Phpactor\Extension\LanguageServerPsalm\Model\Linter\TestLinter;
use Phpactor202301\Phpactor\Extension\LanguageServerPsalm\Tests\Util\DiagnosticBuilder;
use Phpactor202301\Phpactor\LanguageServer\Event\TextDocumentUpdated;
use Phpactor202301\Phpactor\LanguageServer\LanguageServerTesterBuilder;
use Phpactor202301\Phpactor\LanguageServer\Test\LanguageServerTester;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use function Phpactor202301\Amp\Promise\wait;
use function Phpactor202301\Amp\delay;
class PsalmDiagnosticProviderTest extends TestCase
{
    private LanguageServerTester $tester;
    protected function setUp() : void
    {
        parent::setUp();
        $tester = LanguageServerTesterBuilder::create();
        $tester->addDiagnosticsProvider(new PsalmDiagnosticProvider($this->createTestLinter()));
        $tester->enableDiagnostics();
        $tester->enableTextDocuments();
        $this->tester = $tester->build();
        $this->tester->initialize();
    }
    public function testHandleSingle() : void
    {
        $updated = new TextDocumentUpdated(ProtocolFactory::versionedTextDocumentIdentifier('file://path', 12), 'asd');
        $this->tester->textDocument()->open('file:///path', 'asd');
        wait(delay(10));
        self::assertEquals(1, $this->tester->transmitter()->count());
    }
    private function createTestLinter() : TestLinter
    {
        return new TestLinter([DiagnosticBuilder::create()->build()], 10);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerPsalm\\Tests\\DiagnosticProvider\\PsalmDiagnosticProviderTest', 'Phpactor\\Extension\\LanguageServerPsalm\\Tests\\DiagnosticProvider\\PsalmDiagnosticProviderTest', \false);
