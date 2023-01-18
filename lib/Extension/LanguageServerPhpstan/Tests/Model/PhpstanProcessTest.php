<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerPhpstan\Tests\Model;

use Generator;
use Phpactor202301\Phpactor\Extension\LanguageServerPhpstan\Model\PhpstanConfig;
use Phpactor202301\Phpactor\Extension\LanguageServerPhpstan\Model\PhpstanProcess;
use Phpactor202301\Phpactor\LanguageServerProtocol\DiagnosticSeverity;
use Phpactor202301\Phpactor\LanguageServerProtocol\Position;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\Diagnostic;
use Phpactor202301\Psr\Log\NullLogger;
use Phpactor202301\Phpactor\Extension\LanguageServerPhpstan\Tests\IntegrationTestCase;
class PhpstanProcessTest extends IntegrationTestCase
{
    /**
     * @dataProvider provideLint
     */
    public function testLint(string $source, array $expectedDiagnostics) : void
    {
        $this->workspace()->reset();
        $this->workspace()->put('test.php', $source);
        $linter = new PhpstanProcess($this->workspace()->path(), new PhpstanConfig(__DIR__ . '/../../../../../vendor/bin/phpstan', '7'), new NullLogger());
        $diagnostics = \Phpactor202301\Amp\Promise\wait($linter->analyse($this->workspace()->path('test.php')));
        self::assertEquals($expectedDiagnostics, $diagnostics);
    }
    /**
     * @return Generator<mixed>
     */
    public function provideLint() : Generator
    {
        (yield ['<?php $foobar = "string";', []]);
        (yield ['<?php $foobar = $barfoo;', [Diagnostic::fromArray(['range' => new Range(new Position(0, 1), new Position(0, 100)), 'message' => 'Variable $barfoo might not be defined.', 'severity' => DiagnosticSeverity::ERROR, 'source' => 'phpstan'])]]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerPhpstan\\Tests\\Model\\PhpstanProcessTest', 'Phpactor\\Extension\\LanguageServerPhpstan\\Tests\\Model\\PhpstanProcessTest', \false);
