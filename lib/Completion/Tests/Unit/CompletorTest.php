<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Unit;

use Phpactor202301\Phpactor\Completion\Core\ChainCompletor;
use Phpactor202301\Phpactor\Completion\Core\Completor;
use Phpactor202301\Phpactor\Completion\Tests\TestCase;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
class CompletorTest extends TestCase
{
    const EXAMPLE_SOURCE = 'test source';
    const EXAMPLE_OFFSET = 1234;
    /**
     * @var ObjectProphecy|CouldComplete
     */
    private $completor1;
    protected function setUp() : void
    {
        $this->completor1 = $this->prophesize(Completor::class);
    }
    public function testEmptyGeneratorWithNoCompletors() : void
    {
        $completor = $this->create([]);
        $suggestions = $completor->complete($this->textDocument(self::EXAMPLE_SOURCE), ByteOffset::fromInt(self::EXAMPLE_OFFSET));
        $this->assertCount(0, $suggestions);
        $this->assertTrue($suggestions->getReturn());
    }
    public function testReturnsEmptyGeneratorWhenCompletorCouldNotComplete() : void
    {
        $completor = $this->create([$this->completor1->reveal()]);
        $this->completor1->complete($this->textDocument(self::EXAMPLE_SOURCE), ByteOffset::fromInt(self::EXAMPLE_OFFSET))->shouldBeCalled()->will(function () {
            yield from [];
            return \true;
        });
        $suggestions = $completor->complete($this->textDocument(self::EXAMPLE_SOURCE), ByteOffset::fromInt(self::EXAMPLE_OFFSET));
        $this->assertCount(0, $suggestions);
        $this->assertTrue($suggestions->getReturn());
    }
    public function testReturnsSuggestionsFromCompletor() : void
    {
        $expected = [Suggestion::create('foobar')];
        $completor = $this->create([$this->completor1->reveal()]);
        $this->completor1->complete($this->textDocument(self::EXAMPLE_SOURCE), ByteOffset::fromInt(self::EXAMPLE_OFFSET))->shouldBeCalled()->will(function () use($expected) {
            yield from $expected;
            return \true;
        });
        $suggestions = $completor->complete($this->textDocument(self::EXAMPLE_SOURCE), ByteOffset::fromInt(self::EXAMPLE_OFFSET));
        $this->assertEquals($expected, \iterator_to_array($suggestions));
        $this->assertTrue($suggestions->getReturn());
    }
    public function testIsCompleteIfAllCompeltorsReturnedEverything() : void
    {
        $otherCompleter = $this->prophesize(Completor::class);
        $completor = $this->create([$this->completor1->reveal(), $otherCompleter->reveal()]);
        $this->completor1->complete($this->textDocument(self::EXAMPLE_SOURCE), ByteOffset::fromInt(self::EXAMPLE_OFFSET))->shouldBeCalled()->will(function () {
            yield from [];
            return \true;
        });
        $otherCompleter->complete($this->textDocument(self::EXAMPLE_SOURCE), ByteOffset::fromInt(self::EXAMPLE_OFFSET))->shouldBeCalled()->will(function () {
            yield from [];
            return \true;
        });
        $suggestions = $completor->complete($this->textDocument(self::EXAMPLE_SOURCE), ByteOffset::fromInt(self::EXAMPLE_OFFSET));
        $this->assertTrue($suggestions->getReturn());
    }
    public function testIsNotCompleteIfAllCompeltorsDoesNotReturnEverything() : void
    {
        $otherCompleter = $this->prophesize(Completor::class);
        $completor = $this->create([$this->completor1->reveal(), $otherCompleter->reveal()]);
        $this->completor1->complete($this->textDocument(self::EXAMPLE_SOURCE), ByteOffset::fromInt(self::EXAMPLE_OFFSET))->shouldBeCalled()->will(function () {
            yield from [];
            return \false;
        });
        $otherCompleter->complete($this->textDocument(self::EXAMPLE_SOURCE), ByteOffset::fromInt(self::EXAMPLE_OFFSET))->shouldBeCalled()->will(function () {
            yield from [];
            return \true;
        });
        $suggestions = $completor->complete($this->textDocument(self::EXAMPLE_SOURCE), ByteOffset::fromInt(self::EXAMPLE_OFFSET));
        $this->assertFalse($suggestions->getReturn());
    }
    /**
     * @var CouldComplete[] $completors
     */
    public function create(array $completors) : ChainCompletor
    {
        return new ChainCompletor($completors);
    }
    private function textDocument(string $document) : TextDocument
    {
        return TextDocumentBuilder::create($document)->build();
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Unit\\CompletorTest', 'Phpactor\\Completion\\Tests\\Unit\\CompletorTest', \false);
