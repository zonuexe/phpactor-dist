<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Unit\Core\Completor;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Completion\Core\Completor\ArrayCompletor;
use Phpactor202301\Phpactor\Completion\Core\Completor\DedupeCompletor;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
class DedupeCompletorTest extends TestCase
{
    public function testDeduplicates() : void
    {
        $source = TextDocumentBuilder::create('foobar')->build();
        $offset = ByteOffset::fromInt(10);
        $inner = new ArrayCompletor([Suggestion::create('foobar'), Suggestion::create('barfoo'), Suggestion::create('foobar')]);
        $dedupe = new DedupeCompletor($inner);
        $suggestions = $dedupe->complete($source, $offset);
        self::assertEquals([Suggestion::create('foobar'), Suggestion::create('barfoo')], \iterator_to_array($suggestions));
        $this->assertTrue($suggestions->getReturn());
    }
    public function testDeduplicatesWithFqn() : void
    {
        $source = TextDocumentBuilder::create('foobar')->build();
        $offset = ByteOffset::fromInt(10);
        $inner = new ArrayCompletor([Suggestion::create('foobar'), Suggestion::createWithOptions('barfoo', ['name_import' => 'baf']), Suggestion::create('foobar'), Suggestion::createWithOptions('barfoo', ['name_import' => 'bosh'])]);
        $dedupe = new DedupeCompletor($inner, \true);
        $suggestions = $dedupe->complete($source, $offset);
        self::assertEquals([Suggestion::create('foobar'), Suggestion::createWithOptions('barfoo', ['name_import' => 'baf']), Suggestion::createWithOptions('barfoo', ['name_import' => 'bosh'])], \iterator_to_array($suggestions));
        $this->assertTrue($suggestions->getReturn());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Unit\\Core\\Completor\\DedupeCompletorTest', 'Phpactor\\Completion\\Tests\\Unit\\Core\\Completor\\DedupeCompletorTest', \false);
