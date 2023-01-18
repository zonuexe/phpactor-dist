<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\Tests\Unit\Response;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\Rpc\Response\ErrorResponse;
use Exception;
class ErrorResponseTest extends TestCase
{
    public function testFromException() : void
    {
        $exception = new Exception('Hello');
        $response = ErrorResponse::fromException($exception);
        $this->assertEquals('Hello', $response->message());
    }
    public function testFromExceptionWithPrevious() : void
    {
        $exception1 = new Exception('One');
        $exception2 = new Exception('Two', 0, $exception1);
        $exception3 = new Exception('Three', 0, $exception2);
        $response = ErrorResponse::fromException($exception3);
        $this->assertEquals('Three', $response->message());
        $this->assertStringContainsString('One', $response->details());
        $this->assertStringContainsString('Two', $response->details());
        $this->assertStringContainsString('Three', $response->details());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Tests\\Unit\\Response\\ErrorResponseTest', 'Phpactor\\Extension\\Rpc\\Tests\\Unit\\Response\\ErrorResponseTest', \false);
