<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests\Unit\CodeAction;

use Generator;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests\IntegrationTestCase;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeActionContext;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeActionParams;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeActionRequest;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServer\LanguageServerBuilder;
use Phpactor202301\Phpactor\LanguageServer\Test\LanguageServerTester;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use Phpactor202301\Phpactor\TestUtils\ExtractOffset;
class GenerateDecoratorProviderTest extends IntegrationTestCase
{
    /**
     * @dataProvider provideClassCreateProvider
     * @group flakey
     */
    public function testClassCreateProvider(string $source, int $expectedCount) : void
    {
        $this->workspace()->reset();
        [$source, $offset] = ExtractOffset::fromSource($source);
        $tester = $this->container([])->get(LanguageServerBuilder::class)->tester(ProtocolFactory::initializeParams($this->workspace()->path()));
        $tester->initialize();
        \assert($tester instanceof LanguageServerTester);
        $tester->textDocument()->open('file:///foobar', $source);
        $result = $tester->requestAndWait(CodeActionRequest::METHOD, new CodeActionParams(ProtocolFactory::textDocumentIdentifier('file:///foobar'), new Range(PositionConverter::intByteOffsetToPosition((int) $offset, $source), PositionConverter::intByteOffsetToPosition((int) $offset, $source)), new CodeActionContext([])));
        $tester->assertSuccess($result);
        $tester->textDocument()->save('file:///foobar');
        $result = $tester->requestAndWait(CodeActionRequest::METHOD, new CodeActionParams(ProtocolFactory::textDocumentIdentifier('file:///foobar'), new Range(ProtocolFactory::position(0, 8), PositionConverter::intByteOffsetToPosition((int) $offset, $source)), new CodeActionContext([])));
        $tester->assertSuccess($result);
        self::assertCount($expectedCount, $result->result, 'Number of code actions');
    }
    /**
     * @return Generator<mixed>
     */
    public function provideClassCreateProvider() : Generator
    {
        (yield 'class with no interfaces' => [<<<'EOT'
<?php
class Foo<>bar {}

EOT
, 0]);
        (yield 'class with one interface' => [<<<'EOT'
<?php
interface SomeInterface {public function foo(): void {}}
class FooBar implements So<>meInterface {}

EOT
, 1]);
        (yield 'interface provides no actions' => [<<<'EOT'
<?php
interface S<>omeInterface {public function foo(): void {}}

EOT
, 0]);
        (yield 'class with multiple interfaces' => [<<<'EOT'
<?php
interface SomeInterface {public function foo(): void {}}
interface OtherInterface {public function foo(): void {}}
class FooBar implements SomeInterface, Ot<>herInterface {}

EOT
, 1]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\CodeAction\\GenerateDecoratorProviderTest', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\CodeAction\\GenerateDecoratorProviderTest', \false);
