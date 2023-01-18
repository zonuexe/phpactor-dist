<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests\Unit\CodeAction;

use Phpactor202301\Amp\CancellationTokenSource;
use Generator;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\ReplaceQualifierWithImport;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\CodeAction\ReplaceQualifierWithImportProvider;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand\ReplaceQualifierWithImportCommand;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor202301\Phpactor\LanguageServerProtocol\Command;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
use function Phpactor202301\Amp\Promise\wait;
class ReplaceQualifierWithImportProviderTest extends TestCase
{
    use ProphecyTrait;
    const EXAMPLE_SOURCE = 'foobar';
    const EXAMPLE_FILE = 'file:///somefile.php';
    /**
     * @var ObjectProphecy<ReplaceQualifierWithImport>
     */
    private ObjectProphecy $replaceQualifierWithImport;
    public function setUp() : void
    {
        $this->replaceQualifierWithImport = $this->prophesize(ReplaceQualifierWithImport::class);
    }
    /**
     * @dataProvider provideActionsData
     */
    public function testProvideActions(bool $shouldSucceed, array $expectedValue) : void
    {
        $textDocumentItem = new TextDocumentItem(self::EXAMPLE_FILE, 'php', 1, self::EXAMPLE_SOURCE);
        $range = ProtocolFactory::range(0, 0, 0, 5);
        $this->replaceQualifierWithImport->canReplaceWithImport(SourceCode::fromStringAndPath($textDocumentItem->text, $textDocumentItem->uri), $range->start->character)->willReturn($shouldSucceed)->shouldBeCalled();
        $cancel = (new CancellationTokenSource())->getToken();
        $this->assertEquals($expectedValue, wait($this->createProvider()->provideActionsFor($textDocumentItem, $range, $cancel)));
    }
    public function provideActionsData() : Generator
    {
        (yield 'Fail' => [\false, []]);
        (yield 'Success' => [\true, [CodeAction::fromArray(['title' => 'Replace qualifier with import', 'kind' => ReplaceQualifierWithImportProvider::KIND, 'diagnostics' => [], 'command' => new Command('Replace qualifier with import', ReplaceQualifierWithImportCommand::NAME, [self::EXAMPLE_FILE, 0])])]]);
    }
    private function createProvider() : ReplaceQualifierWithImportProvider
    {
        return new ReplaceQualifierWithImportProvider($this->replaceQualifierWithImport->reveal());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\CodeAction\\ReplaceQualifierWithImportProviderTest', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\CodeAction\\ReplaceQualifierWithImportProviderTest', \false);
