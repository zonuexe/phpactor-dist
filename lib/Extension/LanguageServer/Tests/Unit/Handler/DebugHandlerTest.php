<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServer\Tests\Unit\Handler;

use Phpactor202301\Phpactor\Extension\LanguageServer\Handler\DebugHandler;
use Phpactor202301\Phpactor\Extension\LanguageServer\Tests\Unit\LanguageServerTestCase;
class DebugHandlerTest extends LanguageServerTestCase
{
    public function testDumpConfig() : void
    {
        $tester = $this->createTester();
        $response = $tester->requestAndWait(DebugHandler::METHOD_DEBUG_CONFIG, []);
        $this->assertSuccess($response);
    }
    public function testDumpConfigReturningAsJson() : void
    {
        $tester = $this->createTester();
        $response = $tester->requestAndWait(DebugHandler::METHOD_DEBUG_CONFIG, ['return' => \true]);
        $this->assertSuccess($response);
        self::assertJson($response->result);
    }
    public function testDumpWorkspace() : void
    {
        $tester = $this->createTester();
        $response = $tester->requestAndWait(DebugHandler::METHOD_DEBUG_WORKSPACE, []);
        $this->assertSuccess($response);
    }
    public function testStatus() : void
    {
        $tester = $this->createTester();
        $response = $tester->requestAndWait(DebugHandler::METHOD_DEBUG_STATUS, []);
        $this->assertSuccess($response);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServer\\Tests\\Unit\\Handler\\DebugHandlerTest', 'Phpactor\\Extension\\LanguageServer\\Tests\\Unit\\Handler\\DebugHandlerTest', \false);
