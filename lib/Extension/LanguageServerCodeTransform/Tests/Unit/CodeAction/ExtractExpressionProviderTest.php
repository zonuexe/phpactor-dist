<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests\Unit\CodeAction;

use Phpactor202301\Amp\CancellationTokenSource;
use Generator;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\ExtractExpression;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\CodeAction\ExtractExpressionProvider;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand\ExtractExpressionCommand;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor202301\Phpactor\LanguageServerProtocol\Command;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
use function Phpactor202301\Amp\Promise\wait;
class ExtractExpressionProviderTest extends TestCase
{
    use ProphecyTrait;
    const EXAMPLE_SOURCE = 'foobar';
    const EXAMPLE_FILE = 'file:///somefile.php';
    /**
     * @var ObjectProphecy<ExtractExpression>
     */
    private ObjectProphecy $extractExpression;
    public function setUp() : void
    {
        $this->extractExpression = $this->prophesize(ExtractExpression::class);
    }
    /**
     * @dataProvider provideActionsData
     */
    public function testProvideActions(bool $shouldSucceed, array $expectedValue) : void
    {
        $textDocumentItem = new TextDocumentItem(self::EXAMPLE_FILE, 'php', 1, self::EXAMPLE_SOURCE);
        $range = ProtocolFactory::range(0, 0, 0, 5);
        $this->extractExpression->canExtractExpression(SourceCode::fromStringAndPath($textDocumentItem->text, $textDocumentItem->uri), $range->start->character, $range->end->character)->willReturn($shouldSucceed)->shouldBeCalled();
        $cancel = (new CancellationTokenSource())->getToken();
        $this->assertEquals($expectedValue, wait($this->createProvider()->provideActionsFor($textDocumentItem, $range, $cancel)));
    }
    public function provideActionsData() : Generator
    {
        (yield 'Fail' => [\false, []]);
        (yield 'Success' => [\true, [CodeAction::fromArray(['title' => 'Extract expression', 'kind' => ExtractExpressionProvider::KIND, 'diagnostics' => [], 'command' => new Command('Extract method', ExtractExpressionCommand::NAME, [self::EXAMPLE_FILE, 0, 5])])]]);
    }
    private function createProvider() : ExtractExpressionProvider
    {
        return new ExtractExpressionProvider($this->extractExpression->reveal());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\CodeAction\\ExtractExpressionProviderTest', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\CodeAction\\ExtractExpressionProviderTest', \false);
