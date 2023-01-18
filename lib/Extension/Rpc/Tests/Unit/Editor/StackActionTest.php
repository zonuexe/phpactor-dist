<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\Tests\Unit\Editor;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\Rpc\Response;
use Phpactor202301\Phpactor\Extension\Rpc\Response\CollectionResponse;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
class StackActionTest extends TestCase
{
    use ProphecyTrait;
    public function testCreate() : void
    {
        $action1 = $this->prophesize(Response::class);
        $action2 = $this->prophesize(Response::class);
        $action1->name()->willReturn('a1');
        $action2->name()->willReturn('a2');
        $action1->parameters()->willReturn(['p1' => 'v1']);
        $action2->parameters()->willReturn(['p2' => 'v2']);
        $action = CollectionResponse::fromActions([$action1->reveal(), $action2->reveal()]);
        $this->assertEquals(['actions' => [['name' => 'a1', 'parameters' => ['p1' => 'v1']], ['name' => 'a2', 'parameters' => ['p2' => 'v2']]]], $action->parameters());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Tests\\Unit\\Editor\\StackActionTest', 'Phpactor\\Extension\\Rpc\\Tests\\Unit\\Editor\\StackActionTest', \false);
