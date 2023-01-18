<?php

namespace Phpactor202301\Phpactor\DocblockParser\Tests\Unit\Printer;

use Generator;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\DocblockParser\Lexer;
use Phpactor202301\Phpactor\DocblockParser\Parser;
use Phpactor202301\Phpactor\DocblockParser\Printer\TestPrinter;
class PrinterTest extends TestCase
{
    /**
     * @dataProvider provideExamples
     */
    public function testPrint(string $path) : void
    {
        $update = \false;
        $contents = (string) \file_get_contents($path);
        $parts = \explode('---', $contents);
        if (empty($parts[0])) {
            $this->markTestIncomplete(\sprintf('No example given for "%s"', $path));
        }
        $tokens = (new Lexer())->lex($parts[0]);
        $node = (new Parser())->parse($tokens);
        $rendered = (new TestPrinter())->print($node);
        /**
         * @phpstan-ignore-next-line
         */
        if (!isset($parts[1]) || $update) {
            \file_put_contents($path, \implode("---\n", [$parts[0], $rendered]));
            $this->markTestSkipped('Generated output');
        }
        self::assertEquals(\trim($parts[1]), \trim($rendered));
    }
    /**
     * @return Generator<mixed>
     */
    public function provideExamples() : Generator
    {
        foreach ((array) \glob(__DIR__ . '/examples/*.test') as $path) {
            (yield \basename((string) $path) => [$path]);
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Tests\\Unit\\Printer\\PrinterTest', 'Phpactor\\DocblockParser\\Tests\\Unit\\Printer\\PrinterTest', \false);