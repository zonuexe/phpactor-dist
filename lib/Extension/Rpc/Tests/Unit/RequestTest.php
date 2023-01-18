<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\Rpc\Request;
use InvalidArgumentException;
class RequestTest extends TestCase
{
    public function testCanBeCreatedFromArrayAndThrowsExceptionIfParametersAreMissing() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing "action" key');
        Request::fromArray([]);
    }
    public function testCanBeCreatedFromArrayParametersAreOptional() : void
    {
        $request = Request::fromArray(['action' => 'foobar']);
        $result = $request->toArray();
        $this->assertEquals(['action' => 'foobar', 'parameters' => []], $result);
    }
    public function testThrowsExceptionIfInvalidKeysGiven() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid request keys "foobar"');
        Request::fromArray(['action' => 'fo', 'foobar' => 'foobar']);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Tests\\Unit\\RequestTest', 'Phpactor\\Extension\\Rpc\\Tests\\Unit\\RequestTest', \false);
