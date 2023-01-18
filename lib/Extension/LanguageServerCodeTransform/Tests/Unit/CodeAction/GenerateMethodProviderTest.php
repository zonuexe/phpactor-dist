<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests\Unit\CodeAction;

use Phpactor202301\Amp\CancellationTokenSource;
use Generator;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeTransform\Domain\Helper\MissingMethodFinder;
use Phpactor202301\Phpactor\CodeTransform\Domain\Helper\MissingMethodFinder\MissingMethod;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\CodeAction\GenerateMethodProvider;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand\GenerateMethodCommand;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor202301\Phpactor\LanguageServerProtocol\Command;
use Phpactor202301\Phpactor\LanguageServerProtocol\Diagnostic;
use Phpactor202301\Phpactor\LanguageServerProtocol\DiagnosticSeverity;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Prophecy\Argument;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
use function Phpactor202301\Amp\Promise\wait;
class GenerateMethodProviderTest extends TestCase
{
    use ProphecyTrait;
    const EXAMPLE_SOURCE = 'foobar';
    const EXAMPLE_FILE = 'file:///somefile.php';
    /**
     * @var ObjectProphecy<MissingMethodFinder>
     */
    private ObjectProphecy $finder;
    protected function setUp() : void
    {
        $this->finder = $this->prophesize(MissingMethodFinder::class);
    }
    /**
     * @dataProvider provideDiagnosticsTestData
     */
    public function testDiagnostics(array $missingMethods, array $expectedDiagnostics) : void
    {
        $this->finder->find(Argument::type(TextDocument::class))->willReturn($missingMethods);
        $provider = $this->createProvider();
        $cancel = (new CancellationTokenSource())->getToken();
        self::assertEquals($expectedDiagnostics, wait($provider->provideDiagnostics(new TextDocumentItem(self::EXAMPLE_FILE, 'php', 1, self::EXAMPLE_SOURCE), $cancel)));
    }
    /**
     * @return Generator<string,array{array,array}|array{array<int,Phpactor\CodeTransform\Domain\Helper\MissingMethodFinder\MissingMethod>,array<int,Phpactor\LanguageServerProtocol\Diagnostic>}>
     */
    public function provideDiagnosticsTestData() : Generator
    {
        (yield 'No missing methods' => [[], []]);
        (yield 'Missing method' => [[new MissingMethod(self::EXAMPLE_SOURCE, ByteOffsetRange::fromInts(0, 5))], [Diagnostic::fromArray(['range' => ProtocolFactory::range(0, 0, 0, 5), 'message' => 'Method "foobar" does not exist', 'severity' => DiagnosticSeverity::WARNING, 'source' => 'phpactor'])]]);
    }
    /**
     * @dataProvider provideActionsTestData
     */
    public function testProvideActions(array $missingMethods, array $expectedActions) : void
    {
        $this->finder->find(Argument::type(TextDocument::class))->willReturn($missingMethods);
        $provider = $this->createProvider();
        $cancel = (new CancellationTokenSource())->getToken();
        self::assertEquals($expectedActions, wait($provider->provideActionsFor(new TextDocumentItem(self::EXAMPLE_FILE, 'php', 1, self::EXAMPLE_SOURCE), ProtocolFactory::range(0, 0, 0, 0), $cancel)));
    }
    /**
     * @return Generator<string,array{array,array}|array{array<int,Phpactor\CodeTransform\Domain\Helper\MissingMethodFinder\MissingMethod>,array<int,Phpactor\LanguageServerProtocol\CodeAction>}>
     */
    public function provideActionsTestData() : Generator
    {
        (yield 'No missing methods' => [[], []]);
        (yield 'Missing method' => [[new MissingMethod(self::EXAMPLE_SOURCE, ByteOffsetRange::fromInts(0, 5))], [CodeAction::fromArray(['title' => 'Fix "Method "foobar" does not exist"', 'kind' => GenerateMethodProvider::KIND, 'diagnostics' => [Diagnostic::fromArray(['range' => ProtocolFactory::range(0, 0, 0, 5), 'message' => 'Method "foobar" does not exist', 'severity' => DiagnosticSeverity::WARNING, 'source' => 'phpactor'])], 'command' => new Command('Generate method', GenerateMethodCommand::NAME, [self::EXAMPLE_FILE, 0])])]]);
    }
    private function createProvider() : GenerateMethodProvider
    {
        return new GenerateMethodProvider($this->finder->reveal());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\CodeAction\\GenerateMethodProviderTest', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\CodeAction\\GenerateMethodProviderTest', \false);
