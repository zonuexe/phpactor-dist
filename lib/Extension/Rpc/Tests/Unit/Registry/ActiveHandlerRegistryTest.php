<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\Tests\Unit\Registry;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\Rpc\Exception\HandlerNotFound;
use Phpactor202301\Phpactor\Extension\Rpc\Handler\EchoHandler;
use Phpactor202301\Phpactor\Extension\Rpc\Registry\ActiveHandlerRegistry;
class ActiveHandlerRegistryTest extends TestCase
{
    public function testExceptionForUnkown() : void
    {
        $this->expectException(HandlerNotFound::class);
        $this->expectExceptionMessage('No handler "aaa"');
        $action = new EchoHandler();
        $registry = $this->create([$action]);
        $registry->get('aaa');
    }
    public function testGetAction() : void
    {
        $action = new EchoHandler();
        $registry = $this->create([$action]);
        $this->assertSame($action, $registry->get('echo'));
    }
    public function create(array $actions = [])
    {
        return new ActiveHandlerRegistry($actions);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Tests\\Unit\\Registry\\ActiveHandlerRegistryTest', 'Phpactor\\Extension\\Rpc\\Tests\\Unit\\Registry\\ActiveHandlerRegistryTest', \false);
