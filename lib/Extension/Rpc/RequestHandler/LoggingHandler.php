<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\RequestHandler;

use Phpactor202301\Phpactor\Extension\Rpc\RequestHandler;
use Phpactor202301\Phpactor\Extension\Rpc\Response;
use Phpactor202301\Phpactor\Extension\Rpc\Request;
use Phpactor202301\Psr\Log\LoggerInterface;
use Phpactor202301\Psr\Log\LogLevel;
use Phpactor202301\Phpactor\Extension\Rpc\Response\ErrorResponse;
class LoggingHandler implements RequestHandler
{
    public function __construct(private RequestHandler $requestHandler, private LoggerInterface $logger)
    {
    }
    public function handle(Request $request) : Response
    {
        $this->logger->debug('REQUEST', ['action' => $request->name(), 'parameters' => $request->parameters()]);
        $response = $this->requestHandler->handle($request);
        $level = LogLevel::DEBUG;
        if ($response instanceof ErrorResponse) {
            $level = LogLevel::ERROR;
        }
        $this->logger->log($level, 'RESPONSE', ['action' => $response->name(), 'parameters' => $response->parameters()]);
        return $response;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\RequestHandler\\LoggingHandler', 'Phpactor\\Extension\\Rpc\\RequestHandler\\LoggingHandler', \false);
