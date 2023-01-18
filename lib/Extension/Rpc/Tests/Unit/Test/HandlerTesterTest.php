<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\Tests\Unit\Test;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\Rpc\Handler;
use Phpactor202301\Phpactor\Extension\Rpc\Handler\EchoHandler;
use Phpactor202301\Phpactor\Extension\Rpc\Response\EchoResponse;
use Phpactor202301\Phpactor\Extension\Rpc\Test\HandlerTester;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
class HandlerTesterTest extends TestCase
{
    use ProphecyTrait;
    private Handler $handler;
    private ObjectProphecy $response;
    public function setUp() : void
    {
        $this->handler = new EchoHandler();
    }
    public function testTester() : void
    {
        $tester = new HandlerTester($this->handler);
        $response = $tester->handle('echo', ['message' => 'bar']);
        $this->assertInstanceOf(EchoResponse::class, $response);
        $this->assertEquals('bar', $response->message());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Tests\\Unit\\Test\\HandlerTesterTest', 'Phpactor\\Extension\\Rpc\\Tests\\Unit\\Test\\HandlerTesterTest', \false);
