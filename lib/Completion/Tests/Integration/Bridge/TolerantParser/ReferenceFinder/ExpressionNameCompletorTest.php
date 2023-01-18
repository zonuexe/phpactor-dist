<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Integration\Bridge\TolerantParser\ReferenceFinder;

use Generator;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\ReferenceFinder\ExpressionNameCompletor;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\Completion\Tests\Integration\Bridge\TolerantParser\TolerantCompletorTestCase;
use Phpactor202301\Phpactor\ReferenceFinder\NameSearcher;
use Phpactor202301\Phpactor\ReferenceFinder\Search\NameSearchResult;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
class ExpressionNameCompletorTest extends TolerantCompletorTestCase
{
    /**
     * @dataProvider provideComplete
     *
     * @param array<mixed> $expected
     */
    public function testComplete(string $source, array $expected) : void
    {
        $this->assertComplete($source, $expected);
    }
    public function provideComplete() : Generator
    {
        (yield 'new class instance' => ['<?php class Foobar { public function __construct(int $cparam) {} } :int {}; new Foo<>', [['type' => Suggestion::TYPE_CLASS, 'name' => 'Foobar', 'short_description' => 'Foobar', 'snippet' => 'Foobar(${1:\\$cparam})${0}']]]);
        (yield 'new class instance (empty constructor)' => ['<?php class Foobar { public function __construct() {} } :int {}; new Foo<>', [['type' => Suggestion::TYPE_CLASS, 'name' => 'Foobar', 'short_description' => 'Foobar', 'snippet' => 'Foobar()']]]);
        (yield 'class typehint (no instantiation)' => ['<?php class Foobar { public function __construct() {} } :int {}; Fo<>', [['type' => Suggestion::TYPE_CLASS, 'name' => 'Foobar', 'short_description' => 'Foobar']]]);
        (yield 'absolute class typehint' => ['<?php class Foobar { public function __construct() {} } :int {}; \\Fo<>', [['type' => Suggestion::TYPE_CLASS, 'name' => 'FOO', 'short_description' => 'FOO']]]);
        (yield 'function' => ['<?php function bar(int $foo) {}; ba<>', [['type' => Suggestion::TYPE_FUNCTION, 'name' => 'bar', 'short_description' => 'bar', 'snippet' => 'bar(${1:\\$foo})${0}']]]);
        (yield 'function (empty params)' => ['<?php function bar() {}; ba<>', [['type' => Suggestion::TYPE_FUNCTION, 'name' => 'bar', 'short_description' => 'bar', 'snippet' => 'bar()']]]);
        (yield 'constant' => ['<?php define("FOO", "BAR"); FO<>', [['type' => Suggestion::TYPE_CONSTANT, 'name' => 'FOO', 'short_description' => 'FOO']]]);
        (yield 'class constant inside class constant declaration' => ['<?php class Foobar { private const FOO; private const BAR = self::F<>  }', [['type' => Suggestion::TYPE_CONSTANT, 'name' => 'FOOCONST', 'short_description' => 'FOOCONST']]]);
        (yield 'class name inside class constant declaration' => ['<?php class Foobar { private const FOO; private const BAR = sel<>  }', [['type' => Suggestion::TYPE_CLASS, 'name' => 'self', 'short_description' => 'self']]]);
        (yield 'nested class name inside class constant declaration' => ['<?php class Foobar { private const FOO; private const BAR = [ sel<>  }', [['type' => Suggestion::TYPE_CLASS, 'name' => 'self', 'short_description' => 'self']]]);
    }
    protected function createTolerantCompletor(TextDocument $source) : TolerantCompletor
    {
        $searcher = $this->prophesize(NameSearcher::class);
        $searcher->search('FO')->willYield([NameSearchResult::create('constant', 'FOO')]);
        $searcher->search('sel')->willYield([NameSearchResult::create('class', 'self')]);
        $searcher->search('self::F')->willYield([NameSearchResult::create('constant', 'FOOCONST')]);
        $searcher->search('\\Fo')->willYield([NameSearchResult::create('class', 'FOO')]);
        $searcher->search('Foo')->willYield([NameSearchResult::create('class', 'Foobar')]);
        $searcher->search('Fo')->willYield([NameSearchResult::create('class', 'Foobar')]);
        $searcher->search('ba')->willYield([NameSearchResult::create('function', 'bar')]);
        $searcher->search('b')->willYield([NameSearchResult::create('class', 'Phpactor202301\\Foo\\Bar')]);
        $reflector = ReflectorBuilder::create()->addSource($source)->build();
        return new ExpressionNameCompletor($searcher->reveal(), $this->snippetFormatter($reflector));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Integration\\Bridge\\TolerantParser\\ReferenceFinder\\ExpressionNameCompletorTest', 'Phpactor\\Completion\\Tests\\Integration\\Bridge\\TolerantParser\\ReferenceFinder\\ExpressionNameCompletorTest', \false);
