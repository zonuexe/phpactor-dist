<?php

namespace Phpactor202301\Phpactor\Extension\CompletionRpc;

use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\CompletionRpc\Handler\CompleteHandler;
use Phpactor202301\Phpactor\Extension\Completion\CompletionExtension;
use Phpactor202301\Phpactor\Extension\Rpc\RpcExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
class CompletionRpcExtension implements Extension
{
    public function configure(Resolver $schema) : void
    {
    }
    public function load(ContainerBuilder $container) : void
    {
        $container->register('completion_rpc.handler', function (Container $container) {
            return new CompleteHandler($container->get(CompletionExtension::SERVICE_REGISTRY));
        }, [RpcExtension::TAG_RPC_HANDLER => ['name' => CompleteHandler::NAME]]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\CompletionRpc\\CompletionRpcExtension', 'Phpactor\\Extension\\CompletionRpc\\CompletionRpcExtension', \false);
