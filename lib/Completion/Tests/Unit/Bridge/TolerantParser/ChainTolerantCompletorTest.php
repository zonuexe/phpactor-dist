<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Unit\Bridge\TolerantParser;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\ChainTolerantCompletor;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantQualifiable;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantQualifier;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\Completion\Tests\TestCase;
use Phpactor202301\Phpactor\TestUtils\ExtractOffset;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor202301\Prophecy\Argument;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class ChainTolerantCompletorTest extends TestCase
{
    /**
     * @var ObjectProphecy<TolerantCompletor>
     */
    private ObjectProphecy $completor1;
    /**
     * @var ObjectProphecy<TolerantCompletor&TolerantQualifiable>
     */
    private ObjectProphecy $qualifiableCompletor1;
    /**
     * @var ObjectProphecy<TolerantQualifier>
     */
    private ObjectProphecy $qualifier1;
    /**
     * @var ObjectProphecy<TolerantCompletor&TolerantQualifiable>
     */
    private ObjectProphecy $qualifiableCompletor2;
    /**
     * @var ObjectProphecy<TolerantQualifier>
     */
    private ObjectProphecy $qualifier2;
    protected function setUp() : void
    {
        $this->completor1 = $this->prophesize(TolerantCompletor::class);
        $this->qualifiableCompletor1 = $this->prophesize(TolerantCompletor::class)->willImplement(TolerantQualifiable::class);
        $this->qualifiableCompletor2 = $this->prophesize(TolerantCompletor::class)->willImplement(TolerantQualifiable::class);
        $this->qualifier1 = $this->prophesize(TolerantQualifier::class);
        $this->qualifier2 = $this->prophesize(TolerantQualifier::class);
    }
    public function testEmptyResponseWithNoCompletors() : void
    {
        $completor = $this->create([]);
        $suggestions = $completor->complete(TextDocumentBuilder::create('<?php ')->build(), ByteOffset::fromInt(1));
        $this->assertCount(0, $suggestions);
        $this->assertTrue($suggestions->getReturn());
    }
    public function testCallsCompletors() : void
    {
        $completor = $this->create([$this->completor1->reveal()]);
        $this->completor1->complete(Argument::type(Node::class), TextDocumentBuilder::create('<?php ')->build(), ByteOffset::fromInt(1))->will(function () {
            (yield Suggestion::create('foo'));
            return \false;
        });
        $suggestions = $completor->complete(TextDocumentBuilder::create('<?php ')->build(), ByteOffset::fromInt(1));
        $this->assertCount(1, $suggestions);
        $this->assertFalse($suggestions->getReturn());
    }
    public function testPassesCorrectByteOffsetToParser() : void
    {
        $completor = $this->create([$this->completor1->reveal()]);
        [$source, $offset] = ExtractOffset::fromSource(<<<'EOT'
<?php

// 姓名

class A
{
  public function foo()
  {
  }
}

$a = new A;
$<>
EOT
);
        // the parser node passed to the tolerant completor should be the one
        // at the requested char offset
        $this->completor1->complete(Argument::that(function ($arg) {
            return $arg->getText() === '$';
        }), $source, $offset)->will(function ($args) : void {
            return;
        });
        $completor->complete(TextDocumentBuilder::create($source)->build(), ByteOffset::fromInt($offset));
        $this->addToAssertionCount(1);
    }
    public function testExcludesNonQualifingClasses() : void
    {
        $completor = $this->create([$this->qualifiableCompletor1->reveal(), $this->qualifiableCompletor2->reveal()]);
        $this->qualifiableCompletor1->qualifier()->willReturn($this->qualifier1->reveal());
        $this->qualifiableCompletor2->qualifier()->willReturn($this->qualifier2->reveal());
        $this->qualifier1->couldComplete(Argument::type(Node::class))->shouldBeCalled()->will(function (array $args) {
            return $args[0];
        });
        $this->qualifier2->couldComplete(Argument::type(Node::class))->shouldBeCalled()->willReturn(null);
        $this->qualifiableCompletor1->complete(Argument::type(Node::class), TextDocumentBuilder::create('<?php ')->build(), ByteOffset::fromInt(1))->will(function () {
            (yield Suggestion::create('foo'));
            return \true;
        });
        $this->qualifiableCompletor2->complete(Argument::cetera())->shouldNotBeCalled();
        $suggestions = $completor->complete(TextDocumentBuilder::create('<?php ')->build(), ByteOffset::fromInt(1));
        $this->assertCount(1, $suggestions);
        $this->assertTrue($suggestions->getReturn());
    }
    private function create(array $completors) : ChainTolerantCompletor
    {
        return new ChainTolerantCompletor($completors);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Unit\\Bridge\\TolerantParser\\ChainTolerantCompletorTest', 'Phpactor\\Completion\\Tests\\Unit\\Bridge\\TolerantParser\\ChainTolerantCompletorTest', \false);
