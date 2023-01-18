<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\Tests\Unit\RequestHandler;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\Rpc\RequestHandler;
use Phpactor202301\Phpactor\Extension\Rpc\RequestHandler\ExceptionCatchingHandler;
use Phpactor202301\Phpactor\Extension\Rpc\Request;
use Phpactor202301\Phpactor\Extension\Rpc\Response;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Phpactor\Extension\Rpc\Response\ErrorResponse;
use Exception;
class ExceptionCatchingHandlerTest extends TestCase
{
    use ProphecyTrait;
    private ObjectProphecy $innerHandler;
    private ExceptionCatchingHandler $exceptionHandler;
    private ObjectProphecy $response;
    private ObjectProphecy $request;
    public function setUp() : void
    {
        $this->innerHandler = $this->prophesize(RequestHandler::class);
        $this->exceptionHandler = new ExceptionCatchingHandler($this->innerHandler->reveal());
        $this->request = $this->prophesize(Request::class);
        $this->response = $this->prophesize(Response::class);
    }
    public function testDelegate() : void
    {
        $this->innerHandler->handle($this->request->reveal())->willReturn($this->response->reveal());
        $response = $this->exceptionHandler->handle($this->request->reveal());
        $this->assertSame($this->response->reveal(), $response);
    }
    public function testCatchExceptions() : void
    {
        $this->innerHandler->handle($this->request->reveal())->willThrow(new Exception('Test!'));
        $response = $this->exceptionHandler->handle($this->request->reveal());
        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->assertEquals('Test!', $response->message());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Tests\\Unit\\RequestHandler\\ExceptionCatchingHandlerTest', 'Phpactor\\Extension\\Rpc\\Tests\\Unit\\RequestHandler\\ExceptionCatchingHandlerTest', \false);
