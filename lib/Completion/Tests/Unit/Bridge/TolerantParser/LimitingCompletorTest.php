<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Unit\Bridge\TolerantParser;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\LimitingCompletor;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\Qualifier\AlwaysQualfifier;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantQualifiable;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\Completion\Tests\TestCase;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class LimitingCompletorTest extends TestCase
{
    const EXAMPLE_SOURCE = '<?php';
    const EXAMPLE_OFFSET = 15;
    private ObjectProphecy $innerCompletor;
    private ObjectProphecy $node;
    protected function setUp() : void
    {
        $this->innerCompletor = $this->prophesize(TolerantCompletor::class);
        $this->node = $this->prophesize(Node::class);
    }
    public function testNoSuggestions() : void
    {
        $this->innerCompletor->complete($this->node->reveal(), $this->textDocument(self::EXAMPLE_SOURCE), ByteOffset::fromInt(self::EXAMPLE_OFFSET))->will(function () {
            return \true;
            yield;
        });
        $suggestions = $this->create(10)->complete($this->node->reveal(), $this->textDocument(self::EXAMPLE_SOURCE), ByteOffset::fromInt(self::EXAMPLE_OFFSET));
        $this->assertCount(0, $suggestions);
        $this->assertTrue($suggestions->getReturn());
    }
    public function testSomeSuggestions() : void
    {
        $suggestions = [$this->suggestion('foobar'), $this->suggestion('barfoo'), $this->suggestion('carfoo')];
        $this->primeInnerCompletor($suggestions);
        $suggestions = $this->create(10)->complete($this->node->reveal(), $this->textDocument(self::EXAMPLE_SOURCE), ByteOffset::fromInt(self::EXAMPLE_OFFSET));
        $this->assertCount(3, $suggestions);
        $this->assertTrue($suggestions->getReturn());
    }
    public function testAppliesLimit() : void
    {
        $suggestions = [$this->suggestion('foobar'), $this->suggestion('barfoo'), $this->suggestion('carfoo')];
        $this->primeInnerCompletor($suggestions);
        $suggestions = $this->create(2)->complete($this->node->reveal(), $this->textDocument(self::EXAMPLE_SOURCE), ByteOffset::fromInt(self::EXAMPLE_OFFSET));
        $this->assertCount(2, $suggestions);
        $this->assertFalse($suggestions->getReturn());
    }
    public function testIsNotCompleteWhenInnerCompleterIsNotComplete() : void
    {
        $suggestions = [$this->suggestion('foobar'), $this->suggestion('barfoo'), $this->suggestion('carfoo')];
        $this->primeInnerCompletor($suggestions, \false);
        $suggestions = $this->create(10)->complete($this->node->reveal(), $this->textDocument(self::EXAMPLE_SOURCE), ByteOffset::fromInt(self::EXAMPLE_OFFSET));
        $this->assertCount(3, $suggestions);
        $this->assertFalse($suggestions->getReturn());
    }
    public function testQualifiesNonQualifiableCompletors() : void
    {
        $completor = $this->create(10);
        $node = $this->prophesize(Node::class);
        $qualified = $completor->qualifier()->couldComplete($node->reveal());
        $this->assertSame($node->reveal(), $qualified);
    }
    public function testPassesThroughToInnerQualifier() : void
    {
        $node = $this->prophesize(Node::class);
        $this->innerCompletor->willImplement(TolerantQualifiable::class);
        $this->innerCompletor->qualifier()->willReturn(new AlwaysQualfifier())->shouldBeCalled();
        $completor = $this->create(10);
        $qualified = $completor->qualifier()->couldComplete($node->reveal());
        $this->assertSame($node->reveal(), $qualified);
    }
    private function create(int $limit) : LimitingCompletor
    {
        return new LimitingCompletor($this->innerCompletor->reveal(), $limit);
    }
    private function suggestion(string $name)
    {
        return Suggestion::create($name);
    }
    private function primeInnerCompletor(array $suggestions, bool $isComplete = \true) : void
    {
        $this->innerCompletor->complete($this->node->reveal(), $this->textDocument(self::EXAMPLE_SOURCE), ByteOffset::fromInt(self::EXAMPLE_OFFSET))->will(function () use($suggestions, $isComplete) {
            foreach ($suggestions as $suggestion) {
                (yield $suggestion);
            }
            return $isComplete;
        });
    }
    private function textDocument(string $document) : TextDocument
    {
        return TextDocumentBuilder::create($document)->build();
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Unit\\Bridge\\TolerantParser\\LimitingCompletorTest', 'Phpactor\\Completion\\Tests\\Unit\\Bridge\\TolerantParser\\LimitingCompletorTest', \false);
