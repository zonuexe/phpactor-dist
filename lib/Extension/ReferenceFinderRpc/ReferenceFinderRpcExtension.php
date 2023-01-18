<?php

namespace Phpactor202301\Phpactor\Extension\ReferenceFinderRpc;

use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\ReferenceFinderRpc\Handler\GotoDefinitionHandler;
use Phpactor202301\Phpactor\Extension\ReferenceFinderRpc\Handler\GotoImplementationHandler;
use Phpactor202301\Phpactor\Extension\ReferenceFinderRpc\Handler\GotoTypeHandler;
use Phpactor202301\Phpactor\Extension\ReferenceFinder\ReferenceFinderExtension;
use Phpactor202301\Phpactor\Extension\Rpc\RpcExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
class ReferenceFinderRpcExtension implements Extension
{
    public function load(ContainerBuilder $container) : void
    {
        $container->register('reference_finder_rpc.handler.goto_definition', function (Container $container) {
            return new GotoDefinitionHandler($container->get(ReferenceFinderExtension::SERVICE_DEFINITION_LOCATOR));
        }, [RpcExtension::TAG_RPC_HANDLER => ['name' => 'goto_definition']]);
        $container->register('reference_finder_rpc.handler.goto_type', function (Container $container) {
            return new GotoTypeHandler($container->get(ReferenceFinderExtension::SERVICE_TYPE_LOCATOR));
        }, [RpcExtension::TAG_RPC_HANDLER => ['name' => 'goto_type']]);
        $container->register('reference_finder_rpc.handler.goto_implementation', function (Container $container) {
            return new GotoImplementationHandler($container->get(ReferenceFinderExtension::SERVICE_IMPLEMENTATION_FINDER));
        }, [RpcExtension::TAG_RPC_HANDLER => ['name' => 'goto_implementation']]);
    }
    public function configure(Resolver $schema) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ReferenceFinderRpc\\ReferenceFinderRpcExtension', 'Phpactor\\Extension\\ReferenceFinderRpc\\ReferenceFinderRpcExtension', \false);
