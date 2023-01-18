<?php

namespace Phpactor202301\Phpactor\Extension\ReferenceFinderRpc\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\ReferenceFinderRpc\ReferenceFinderRpcExtension;
use Phpactor202301\Phpactor\Extension\ReferenceFinder\ReferenceFinderExtension;
use Phpactor202301\Phpactor\Extension\Rpc\Request;
use Phpactor202301\Phpactor\Extension\Rpc\RequestHandler;
use Phpactor202301\Phpactor\Extension\Rpc\Response\ErrorResponse;
use Phpactor202301\Phpactor\Extension\Rpc\RpcExtension;
class ReferenceFinderRpcExtensionTest extends TestCase
{
    public function testGotoDefinition() : void
    {
        $container = $this->createContainer();
        $handler = $container->get(RpcExtension::SERVICE_REQUEST_HANDLER);
        $this->assertInstanceOf(RequestHandler::class, $handler);
        $response = $handler->handle(Request::fromNameAndParameters('goto_definition', ['offset' => 10, 'source' => '<?php ' . __CLASS__ . ';', 'path' => __FILE__]));
        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->assertStringContainsString('No definition locators', $response->message());
    }
    public function testGotoType() : void
    {
        $container = $this->createContainer();
        $handler = $container->get(RpcExtension::SERVICE_REQUEST_HANDLER);
        $this->assertInstanceOf(RequestHandler::class, $handler);
        $response = $handler->handle(Request::fromNameAndParameters('goto_type', ['offset' => 10, 'source' => '<?php ' . __CLASS__ . ';', 'path' => __FILE__]));
        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->assertStringContainsString('No type locators', $response->message());
    }
    private function createContainer() : Container
    {
        $container = PhpactorContainer::fromExtensions([ReferenceFinderExtension::class, ReferenceFinderRpcExtension::class, RpcExtension::class, LoggingExtension::class]);
        return $container;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ReferenceFinderRpc\\Tests\\Unit\\ReferenceFinderRpcExtensionTest', 'Phpactor\\Extension\\ReferenceFinderRpc\\Tests\\Unit\\ReferenceFinderRpcExtensionTest', \false);
