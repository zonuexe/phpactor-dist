<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests\Unit\CodeAction;

use Phpactor202301\Amp\CancellationTokenSource;
use Closure;
use Generator;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\ClassName;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\ClassToFile;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\FilePath;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\FilePathCandidates;
use Phpactor202301\Phpactor\CodeTransform\Domain\GenerateNew;
use Phpactor202301\Phpactor\CodeTransform\Domain\Generators;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\RangeConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor202301\Phpactor\TestUtils\ExtractOffset;
use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics\UnresolvableNameProvider;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use function Phpactor202301\Amp\Promise\wait;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\CodeAction\CreateUnresolvableClassProvider;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests\IntegrationTestCase;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
class CreateUnresolvableClassProviderTest extends IntegrationTestCase
{
    use ProphecyTrait;
    /**
     * @dataProvider provideCodeAction
     */
    public function testReturnsCodeActions(string $source, Closure $assertion) : void
    {
        [$source, $start, $end] = ExtractOffset::fromSource($source);
        $generateNew = $this->prophesize(GenerateNew::class);
        $classToFile = $this->prophesize(ClassToFile::class);
        $classToFile->classToFileCandidates(ClassName::fromString('Foo'))->willReturn(FilePathCandidates::fromFilePaths([FilePath::fromString('/foo')]));
        $reflector = ReflectorBuilder::create()->addDiagnosticProvider(new UnresolvableNameProvider(\false))->build();
        $provider = new CreateUnresolvableClassProvider($reflector, new Generators(['foobar' => $generateNew->reveal()]), $classToFile->reveal());
        $actions = wait($provider->provideActionsFor(ProtocolFactory::textDocumentItem('file://foo', $source), RangeConverter::toLspRange(ByteOffsetRange::fromInts((int) $start, (int) $end), $source), (new CancellationTokenSource())->getToken()));
        $assertion(...$actions);
    }
    /**
     * @return Generator<string,mixed>
     */
    public function provideCodeAction() : Generator
    {
        (yield 'empty file' => ['<<>?php <>', function (CodeAction ...$actions) : void {
            self::assertCount(0, $actions);
        }]);
        (yield 'In range' => ['<?php new Fo<>o<>();', function (CodeAction ...$actions) : void {
            self::assertCount(1, $actions);
            self::assertEquals('Create foobar file for "Foo"', $actions[0]->title);
        }]);
        (yield 'Out of range' => ['<?php <> <>new Foo();', function (CodeAction ...$actions) : void {
            self::assertCount(0, $actions);
        }]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\CodeAction\\CreateUnresolvableClassProviderTest', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\CodeAction\\CreateUnresolvableClassProviderTest', \false);
