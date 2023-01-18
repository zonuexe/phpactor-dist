<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Unit\Core\Completor;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Completion\Core\Completor\ArrayCompletor;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\Completion\Core\Completor\LimitingCompletor;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
class LimitingCompletorTest extends TestCase
{
    public function testLimitsResults() : void
    {
        $source = TextDocumentBuilder::create('foobar')->build();
        $offset = ByteOffset::fromInt(10);
        $inner = new ArrayCompletor([Suggestion::create('foobar'), Suggestion::create('foobar'), Suggestion::create('foobar'), Suggestion::create('foobar'), Suggestion::create('foobar')]);
        $dedupe = new LimitingCompletor($inner, 2);
        $suggestions = $dedupe->complete($source, $offset);
        self::assertEquals([Suggestion::create('foobar'), Suggestion::create('foobar')], \iterator_to_array($suggestions));
        $this->assertFalse($suggestions->getReturn());
    }
    public function testDoesNotLimitsResults() : void
    {
        $source = TextDocumentBuilder::create('foobar')->build();
        $offset = ByteOffset::fromInt(10);
        $inner = new ArrayCompletor([Suggestion::create('foobar'), Suggestion::create('foobar')]);
        $dedupe = new LimitingCompletor($inner, 2);
        $suggestions = $dedupe->complete($source, $offset);
        self::assertEquals([Suggestion::create('foobar'), Suggestion::create('foobar')], \iterator_to_array($suggestions));
        $this->assertTrue($suggestions->getReturn());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Unit\\Core\\Completor\\LimitingCompletorTest', 'Phpactor\\Completion\\Tests\\Unit\\Core\\Completor\\LimitingCompletorTest', \false);
