<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerWorseReflection\Tests\Unit\DiagnosticProvider;

use Phpactor202301\Amp\CancellationTokenSource;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\LanguageServerWorseReflection\DiagnosticProvider\WorseDiagnosticProvider;
use Phpactor202301\Phpactor\LanguageServerProtocol\Diagnostic;
use Phpactor202301\Phpactor\LanguageServerProtocol\DiagnosticSeverity as PhpactorDiagnosticSeverity;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
use Phpactor202301\Phpactor\WorseReflection\Core\DiagnosticProvider\BareDiagnostic;
use Phpactor202301\Phpactor\WorseReflection\Core\DiagnosticProvider\InMemoryDiagnosticProvider;
use Phpactor202301\Phpactor\WorseReflection\Core\DiagnosticSeverity;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
use function Phpactor202301\Amp\Promise\wait;
class WorseDiagnosticProviderTest extends TestCase
{
    public function testDiagnostics() : void
    {
        $reflector = ReflectorBuilder::create()->addDiagnosticProvider(new InMemoryDiagnosticProvider([new BareDiagnostic(ByteOffsetRange::fromInts(1, 1), DiagnosticSeverity::WARNING(), 'Foo')]))->build();
        $cancel = (new CancellationTokenSource())->getToken();
        $lspDiagnostics = wait((new WorseDiagnosticProvider($reflector))->provideDiagnostics(ProtocolFactory::textDocumentItem('file:///foo', 'foo'), $cancel));
        /** @var Diagnostic[] $lspDiagnostics */
        self::assertCount(1, $lspDiagnostics);
        self::assertInstanceOf(Diagnostic::class, $lspDiagnostics[0]);
        self::assertEquals('Foo', $lspDiagnostics[0]->message);
        self::assertEquals(PhpactorDiagnosticSeverity::WARNING, $lspDiagnostics[0]->severity);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerWorseReflection\\Tests\\Unit\\DiagnosticProvider\\WorseDiagnosticProviderTest', 'Phpactor\\Extension\\LanguageServerWorseReflection\\Tests\\Unit\\DiagnosticProvider\\WorseDiagnosticProviderTest', \false);
