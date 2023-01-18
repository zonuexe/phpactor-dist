<?php

namespace Phpactor202301\Phpactor\Extension\CompletionRpc\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\CompletionRpc\CompletionRpcExtension;
use Phpactor202301\Phpactor\Extension\Completion\CompletionExtension;
use Phpactor202301\Phpactor\Extension\Rpc\Request;
use Phpactor202301\Phpactor\Extension\Rpc\RequestHandler;
use Phpactor202301\Phpactor\Extension\Rpc\Response\ReturnResponse;
use Phpactor202301\Phpactor\Extension\Rpc\RpcExtension;
class CompletionRpcExtensionTest extends TestCase
{
    public function testAddsCompletionHandler() : void
    {
        $handler = $this->createRequestHandler();
        $response = $handler->handle(Request::fromNameAndParameters('complete', ['source' => '', 'offset' => 1]));
        $this->assertInstanceOf(ReturnResponse::class, $response);
    }
    private function createRequestHandler() : RequestHandler
    {
        $container = PhpactorContainer::fromExtensions([CompletionRpcExtension::class, RpcExtension::class, CompletionExtension::class, LoggingExtension::class]);
        return $container->get(RpcExtension::SERVICE_REQUEST_HANDLER);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\CompletionRpc\\Tests\\Unit\\CompletionRpcExtensionTest', 'Phpactor\\Extension\\CompletionRpc\\Tests\\Unit\\CompletionRpcExtensionTest', \false);
