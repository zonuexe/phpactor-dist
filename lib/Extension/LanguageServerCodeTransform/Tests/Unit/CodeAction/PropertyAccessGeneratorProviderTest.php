<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests\Unit\CodeAction;

use Phpactor202301\Amp\CancellationTokenSource;
use Generator;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\RangeConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\CodeAction\PropertyAccessGeneratorProvider;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor202301\Phpactor\LanguageServerProtocol\Command;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\TestUtils\ExtractOffset;
use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use function Phpactor202301\Amp\Promise\wait;
class PropertyAccessGeneratorProviderTest extends TestCase
{
    use ProphecyTrait;
    const EXAMPLE_FILE = 'file:///somefile.php';
    protected function setUp() : void
    {
    }
    /**
     * @dataProvider provideActionsTestData
     */
    public function testProvideActions(string $sourceCode, array $expectedActions) : void
    {
        [$source, $start, $end] = ExtractOffset::fromSource($sourceCode);
        $provider = $this->createProvider($source);
        $cancel = (new CancellationTokenSource())->getToken();
        self::assertEquals($expectedActions, wait($provider->provideActionsFor(new TextDocumentItem(self::EXAMPLE_FILE, 'php', 1, $source), RangeConverter::toLspRange(ByteOffsetRange::fromInts((int) $start, (int) $end), $source), $cancel)));
    }
    public function provideActionsTestData() : Generator
    {
        (yield 'provide actions' => ['<?php class Foo { <>private $foo;<> }', [CodeAction::fromArray(['title' => 'Generate 1 accessor(s)', 'kind' => 'quickfix.generate_accessors', 'command' => new Command('Generate 1 accessor(s)', 'generate_accessors', [self::EXAMPLE_FILE, 18, ['foo']])])]]);
    }
    private function createProvider(string $sourceCode) : PropertyAccessGeneratorProvider
    {
        $reflector = ReflectorBuilder::create()->addSource($sourceCode)->build();
        return new PropertyAccessGeneratorProvider('quickfix.generate_accessors', 'generate_accessors', 'accessor', $reflector);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\CodeAction\\PropertyAccessGeneratorProviderTest', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\CodeAction\\PropertyAccessGeneratorProviderTest', \false);
