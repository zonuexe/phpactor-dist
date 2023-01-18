<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\Tests\Unit\RequestHandler;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\Rpc\RequestHandler;
use Phpactor202301\Phpactor\Extension\Rpc\Request;
use Phpactor202301\Phpactor\Extension\Rpc\Response;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
use Phpactor202301\Phpactor\Extension\Rpc\Response\ErrorResponse;
use Phpactor202301\Psr\Log\LoggerInterface;
use Phpactor202301\Phpactor\Extension\Rpc\RequestHandler\LoggingHandler;
use Phpactor202301\Psr\Log\LogLevel;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
class LoggingHandlerTest extends TestCase
{
    use ProphecyTrait;
    /**
     * @var ObjectProphecy<RequestHandler>
     */
    private ObjectProphecy $innerHandler;
    private LoggingHandler $loggingHandler;
    /**
     * @var ObjectProphecy<Response>
     */
    private ObjectProphecy $response;
    /**
     * @var ObjectProphecy<Request>
     */
    private ObjectProphecy $request;
    /**
     * @var ObjectProphecy<LoggerInterface>
     */
    private ObjectProphecy $logger;
    public function setUp() : void
    {
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->innerHandler = $this->prophesize(RequestHandler::class);
        $this->loggingHandler = new LoggingHandler($this->innerHandler->reveal(), $this->logger->reveal());
        $this->response = $this->prophesize(Response::class);
        $this->request = $this->prophesize(Request::class);
        $this->request->name()->willReturn('req-name');
        $this->request->parameters()->willReturn(['p1' => 'v1']);
        $this->response->name()->willReturn('res-name');
        $this->response->parameters()->willReturn(['p1' => 'v1']);
        $this->expectedRequestData = ['action' => 'req-name', 'parameters' => ['p1' => 'v1']];
        $this->expectedResponseData = ['action' => 'res-name', 'parameters' => ['p1' => 'v1']];
    }
    public function testLogging() : void
    {
        $this->innerHandler->handle($this->request->reveal())->willReturn($this->response->reveal());
        $response = $this->loggingHandler->handle($this->request->reveal());
        $this->assertSame($this->response->reveal(), $response);
        $this->logger->debug('REQUEST', $this->expectedRequestData)->shouldHaveBeenCalled();
        $this->logger->log(LogLevel::DEBUG, 'RESPONSE', $this->expectedResponseData)->shouldHaveBeenCalled();
    }
    public function testLoggingWithError() : void
    {
        $response = ErrorResponse::fromMessageAndDetails('foobar', 'barfoo');
        $expected = ['action' => $response->name(), 'parameters' => $response->parameters()];
        $this->innerHandler->handle($this->request->reveal())->willReturn($response);
        $response = $this->loggingHandler->handle($this->request->reveal());
        $this->logger->log(LogLevel::ERROR, 'RESPONSE', $expected)->shouldHaveBeenCalled();
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Tests\\Unit\\RequestHandler\\LoggingHandlerTest', 'Phpactor\\Extension\\Rpc\\Tests\\Unit\\RequestHandler\\LoggingHandlerTest', \false);