<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests\Unit\CodeAction;

use Phpactor202301\Amp\CancellationTokenSource;
use Generator;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\ExtractConstant;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\CodeAction\ExtractConstantProvider;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand\ExtractConstantCommand;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor202301\Phpactor\LanguageServerProtocol\Command;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
use function Phpactor202301\Amp\Promise\wait;
class ExtractConstantProviderTest extends TestCase
{
    use ProphecyTrait;
    const EXAMPLE_SOURCE = 'foobar';
    const EXAMPLE_FILE = 'file:///somefile.php';
    /**
     * @var ObjectProphecy<ExtractConstant>
     */
    private ObjectProphecy $extractConstant;
    public function setUp() : void
    {
        $this->extractConstant = $this->prophesize(ExtractConstant::class);
    }
    /**
     * @dataProvider provideActionsData
     */
    public function testProvideActions(bool $shouldSucceed, array $expectedValue) : void
    {
        $textDocumentItem = new TextDocumentItem(self::EXAMPLE_FILE, 'php', 1, self::EXAMPLE_SOURCE);
        $range = ProtocolFactory::range(0, 0, 0, 5);
        $this->extractConstant->canExtractConstant(SourceCode::fromStringAndPath($textDocumentItem->text, $textDocumentItem->uri), $range->start->character)->willReturn($shouldSucceed)->shouldBeCalled();
        $cancel = (new CancellationTokenSource())->getToken();
        $this->assertEquals($expectedValue, wait($this->createProvider()->provideActionsFor($textDocumentItem, $range, $cancel)));
    }
    public function provideActionsData() : Generator
    {
        (yield 'Fail' => [\false, []]);
        (yield 'Success' => [\true, [CodeAction::fromArray(['title' => 'Extract constant', 'kind' => ExtractConstantProvider::KIND, 'diagnostics' => [], 'command' => new Command('Extract constant', ExtractConstantCommand::NAME, [self::EXAMPLE_FILE, 0, 5])])]]);
    }
    private function createProvider() : ExtractConstantProvider
    {
        return new ExtractConstantProvider($this->extractConstant->reveal());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\CodeAction\\ExtractConstantProviderTest', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\CodeAction\\ExtractConstantProviderTest', \false);
