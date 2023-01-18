<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests\Unit\CodeAction;

use Phpactor202301\Amp\CancellationTokenSource;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\ExtractMethod;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\CodeAction\ExtractMethodProvider;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand\ExtractMethodCommand;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor202301\Phpactor\LanguageServerProtocol\Command;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
use function Phpactor202301\Amp\Promise\wait;
use Generator;
class ExtractMethodProviderTest extends TestCase
{
    use ProphecyTrait;
    const EXAMPLE_SOURCE = 'foobar';
    const EXAMPLE_FILE = 'file:///somefile.php';
    private ObjectProphecy $extractMethod;
    public function setUp() : void
    {
        $this->extractMethod = $this->prophesize(ExtractMethod::class);
    }
    /**
     * @dataProvider provideActionsData
     */
    public function testProvideActions(bool $shouldSucceed, array $expectedValue) : void
    {
        $textDocumentItem = new TextDocumentItem(self::EXAMPLE_FILE, 'php', 1, self::EXAMPLE_SOURCE);
        $range = ProtocolFactory::range(0, 0, 0, 5);
        $this->extractMethod->canExtractMethod(SourceCode::fromStringAndPath($textDocumentItem->text, $textDocumentItem->uri), $range->start->character, $range->end->character)->willReturn($shouldSucceed)->shouldBeCalled();
        $cancel = (new CancellationTokenSource())->getToken();
        $this->assertEquals($expectedValue, wait($this->createProvider()->provideActionsFor($textDocumentItem, $range, $cancel)));
    }
    public function provideActionsData() : Generator
    {
        (yield 'Fail' => [\false, []]);
        (yield 'Success' => [\true, [CodeAction::fromArray(['title' => 'Extract method', 'kind' => ExtractMethodProvider::KIND, 'diagnostics' => [], 'command' => new Command('Extract method', ExtractMethodCommand::NAME, [self::EXAMPLE_FILE, 0, 5])])]]);
    }
    private function createProvider() : ExtractMethodProvider
    {
        // @phpstan-ignore-next-line
        return new ExtractMethodProvider($this->extractMethod->reveal());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\CodeAction\\ExtractMethodProviderTest', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\CodeAction\\ExtractMethodProviderTest', \false);
