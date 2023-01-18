<?php

namespace Phpactor202301\Phpactor\Extension\ContextMenu;

use Phpactor202301\Phpactor\CodeTransform\Domain\Helper\InterestingOffsetFinder;
use Phpactor202301\Phpactor\Extension\ContextMenu\Handler\ContextMenuHandler;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Extension\ContextMenu\Model\ContextMenu;
use Phpactor202301\Phpactor\Extension\Rpc\RpcExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
class ContextMenuExtension implements Extension
{
    const SERVICE_REQUEST_HANDLER = 'rpc.request_handler';
    public function load(ContainerBuilder $container) : void
    {
        $container->register('rpc.handler.context_menu', function (Container $container) {
            return new ContextMenuHandler($container->get(WorseReflectionExtension::SERVICE_REFLECTOR), $container->get(InterestingOffsetFinder::class), $container->get('application.helper.class_file_normalizer'), ContextMenu::fromArray(\json_decode(\file_get_contents(__DIR__ . '/menu.json'), \true)), $container);
        }, [RpcExtension::TAG_RPC_HANDLER => ['name' => ContextMenuHandler::NAME]]);
    }
    public function configure(Resolver $schema) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ContextMenu\\ContextMenuExtension', 'Phpactor\\Extension\\ContextMenu\\ContextMenuExtension', \false);
