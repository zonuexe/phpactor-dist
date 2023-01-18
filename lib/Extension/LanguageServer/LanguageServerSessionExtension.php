<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServer;

use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\LanguageServerProtocol\ClientCapabilities;
use Phpactor202301\Phpactor\LanguageServerProtocol\InitializeParams;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ResponseWatcher;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ResponseWatcher\DeferredResponseWatcher;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\RpcClient;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\RpcClient\JsonRpcClient;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\Transmitter\MessageTransmitter;
use Phpactor202301\Phpactor\LanguageServer\WorkDoneProgress\MessageProgressNotifier;
use Phpactor202301\Phpactor\LanguageServer\WorkDoneProgress\ProgressNotifier;
use Phpactor202301\Phpactor\LanguageServer\WorkDoneProgress\WorkDoneProgressNotifier;
use Phpactor202301\Phpactor\MapResolver\Resolver;
class LanguageServerSessionExtension implements Extension
{
    public function __construct(private MessageTransmitter $transmitter, private InitializeParams $initializeParams)
    {
    }
    public function load(ContainerBuilder $container) : void
    {
        $container->register(ClientCapabilities::class, function (Container $container) {
            return $this->initializeParams->capabilities;
        });
        $container->register(InitializeParams::class, function (Container $container) {
            return $this->initializeParams;
        });
        $container->register(MessageTransmitter::class, function (Container $container) {
            return $this->transmitter;
        });
        $container->register(ResponseWatcher::class, function (Container $container) {
            return new DeferredResponseWatcher();
        });
        $container->register(ClientApi::class, function (Container $container) {
            return new ClientApi($container->get(RpcClient::class));
        });
        $container->register(RpcClient::class, function (Container $container) {
            return new JsonRpcClient($this->transmitter, $container->get(ResponseWatcher::class));
        });
        $container->register(ProgressNotifier::class, function (Container $container) {
            $capabilities = $container->get(ClientCapabilities::class);
            if ($capabilities->window['workDoneProgress'] ?? \false) {
                return new WorkDoneProgressNotifier($container->get(ClientApi::class));
            }
            return new MessageProgressNotifier($container->get(ClientApi::class));
        });
    }
    public function configure(Resolver $schema) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServer\\LanguageServerSessionExtension', 'Phpactor\\Extension\\LanguageServer\\LanguageServerSessionExtension', \false);
