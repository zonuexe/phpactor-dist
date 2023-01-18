<?php

namespace Phpactor202301\Phpactor\DocblockParser\Tests\Benchmark;

use Phpactor202301\Phpactor\DocblockParser\Lexer;
use Phpactor202301\Phpactor\DocblockParser\Parser;
class PhpactorParserBench extends AbstractParserBenchCase
{
    private Parser $parser;
    private Lexer $lexer;
    public function setUp() : void
    {
        $this->parser = new Parser();
        $this->lexer = new Lexer();
    }
    public function parse(string $doc) : void
    {
        $this->parser->parse($this->lexer->lex($doc));
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Tests\\Benchmark\\PhpactorParserBench', 'Phpactor\\DocblockParser\\Tests\\Benchmark\\PhpactorParserBench', \false);
