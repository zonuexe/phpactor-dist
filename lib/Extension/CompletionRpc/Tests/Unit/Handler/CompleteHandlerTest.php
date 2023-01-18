<?php

namespace Phpactor202301\Phpactor\Extension\CompletionRpc\Tests\Unit\Handler;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Completion\Core\Completor;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\Completion\Core\TypedCompletorRegistry;
use Phpactor202301\Phpactor\Extension\CompletionRpc\Handler\CompleteHandler;
use Phpactor202301\Phpactor\Extension\Rpc\Response\ReturnResponse;
use Phpactor202301\Phpactor\Extension\Rpc\Test\HandlerTester;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class CompleteHandlerTest extends TestCase
{
    use ProphecyTrait;
    private ObjectProphecy $completor;
    public function setUp() : void
    {
        $this->completor = $this->prophesize(Completor::class);
        $this->registry = new TypedCompletorRegistry(['php' => $this->completor->reveal()]);
    }
    public function testHandler() : void
    {
        $handler = new CompleteHandler($this->registry);
        $this->completor->complete(TextDocumentBuilder::create('aaa')->language('php')->build(), ByteOffset::fromInt(1234))->will(function () {
            (yield Suggestion::create('aaa'));
            (yield Suggestion::create('bbb'));
        });
        $action = (new HandlerTester($handler))->handle('complete', ['source' => 'aaa', 'offset' => 1234]);
        $this->assertInstanceOf(ReturnResponse::class, $action);
        $this->assertCount(2, $action->value()['suggestions']);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\CompletionRpc\\Tests\\Unit\\Handler\\CompleteHandlerTest', 'Phpactor\\Extension\\CompletionRpc\\Tests\\Unit\\Handler\\CompleteHandlerTest', \false);
