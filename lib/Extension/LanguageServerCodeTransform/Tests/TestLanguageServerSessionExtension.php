<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests;

use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\LanguageServer\LanguageServerSessionExtension;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\Transmitter\TestMessageTransmitter;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use Phpactor202301\Phpactor\MapResolver\Resolver;
class TestLanguageServerSessionExtension implements Extension
{
    private LanguageServerSessionExtension $sessionExtension;
    public function __construct()
    {
        $transmitter = new TestMessageTransmitter();
        $this->sessionExtension = new LanguageServerSessionExtension($transmitter, ProtocolFactory::initializeParams());
    }
    public function load(ContainerBuilder $container) : void
    {
        $this->sessionExtension->load($container);
    }
    public function configure(Resolver $schema) : void
    {
        $this->sessionExtension->configure($schema);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\TestLanguageServerSessionExtension', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\TestLanguageServerSessionExtension', \false);
