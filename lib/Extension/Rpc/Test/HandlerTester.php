<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\Test;

use Phpactor202301\Phpactor\Extension\Rpc\Handler;
use Phpactor202301\Phpactor\Extension\Rpc\Registry\ActiveHandlerRegistry;
use Phpactor202301\Phpactor\Extension\Rpc\Request;
use Phpactor202301\Phpactor\Extension\Rpc\RequestHandler\RequestHandler;
class HandlerTester
{
    public function __construct(private Handler $handler)
    {
    }
    public function handle(string $actionName, array $parameters)
    {
        $registry = new ActiveHandlerRegistry([$this->handler]);
        $requestHandler = new RequestHandler($registry);
        $request = Request::fromNameAndParameters($actionName, $parameters);
        return $requestHandler->handle($request);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Test\\HandlerTester', 'Phpactor\\Extension\\Rpc\\Test\\HandlerTester', \false);
