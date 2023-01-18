<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServer\Tests\Unit\Listener;

use Phpactor202301\DTL\Invoke\Invoke;
use Phpactor202301\Phpactor\Extension\LanguageServer\Tests\Unit\LanguageServerTestCase;
use Phpactor202301\Phpactor\LanguageServerProtocol\ClientCapabilities;
use Phpactor202301\Phpactor\LanguageServerProtocol\InitializeParams;
class InvalidConfigListenerTest extends LanguageServerTestCase
{
    public function testShowErrorMessageOnInvalidConfig() : void
    {
        $tester = $this->createTester(Invoke::new(InitializeParams::class, ['capabilities' => new ClientCapabilities(), 'rootUri' => 'file:///', 'initializationOptions' => ['foobar' => 'barfoo']]));
        $response = $tester->initialize();
        $message = $tester->transmitter()->filterByMethod('window/showMessage')->shiftNotification();
        self::assertNotNull($message);
        self::assertStringContainsString('are not known', $message->params['message']);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServer\\Tests\\Unit\\Listener\\InvalidConfigListenerTest', 'Phpactor\\Extension\\LanguageServer\\Tests\\Unit\\Listener\\InvalidConfigListenerTest', \false);
