<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerPhpstan\Tests\Provider;

use Generator;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\LanguageServerPhpstan\Model\Linter\TestLinter;
use Phpactor202301\Phpactor\Extension\LanguageServerPhpstan\Provider\PhpstanDiagnosticProvider;
use Phpactor202301\Phpactor\Extension\LanguageServerPhpstan\Tests\Util\DiagnosticBuilder;
use Phpactor202301\Phpactor\LanguageServer\Event\TextDocumentUpdated;
use Phpactor202301\Phpactor\LanguageServer\LanguageServerTesterBuilder;
use Phpactor202301\Phpactor\LanguageServer\Test\LanguageServerTester;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use function Phpactor202301\Amp\Promise\wait;
use function Phpactor202301\Amp\delay;
class PhpstanDiagnosticProviderTest extends TestCase
{
    private LanguageServerTester $tester;
    protected function setUp() : void
    {
        parent::setUp();
        $tester = LanguageServerTesterBuilder::create();
        $tester->addDiagnosticsProvider(new PhpstanDiagnosticProvider($this->createTestLinter()));
        $tester->enableDiagnostics();
        $tester->enableTextDocuments();
        $this->tester = $tester->build();
        $this->tester->initialize();
    }
    /**
     * @return Generator<mixed>
     */
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
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerPhpstan\\Tests\\Provider\\PhpstanDiagnosticProviderTest', 'Phpactor\\Extension\\LanguageServerPhpstan\\Tests\\Provider\\PhpstanDiagnosticProviderTest', \false);
