<?php

namespace Phpactor202301\Phpactor\Extension\CompletionExtra;

use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Extension\CompletionExtra\Rpc\HoverHandler;
use Phpactor202301\Phpactor\Extension\Completion\CompletionExtension;
use Phpactor202301\Phpactor\Extension\Console\ConsoleExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\Extension\Rpc\RpcExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Extension\CompletionExtra\Command\CompleteCommand;
use Phpactor202301\Phpactor\Extension\CompletionExtra\Application\Complete;
class CompletionExtraExtension implements Extension
{
    const CLASS_COMPLETOR_LIMIT = 'completion.completor.class.limit';
    public function load(ContainerBuilder $container) : void
    {
        $this->registerCommands($container);
        $this->registerApplicationServices($container);
        $this->registerRpc($container);
    }
    public function configure(Resolver $schema) : void
    {
    }
    private function registerRpc(ContainerBuilder $container) : void
    {
        $container->register('class_mover.handler.hover', function (Container $container) {
            return new HoverHandler($container->get(WorseReflectionExtension::SERVICE_REFLECTOR), $container->get(CompletionExtension::SERVICE_SHORT_DESC_FORMATTER));
        }, [RpcExtension::TAG_RPC_HANDLER => ['name' => HoverHandler::NAME]]);
    }
    private function registerCommands(ContainerBuilder $container) : void
    {
        $container->register('command.complete', function (Container $container) {
            return new CompleteCommand($container->get('application.complete'), $container->get('console.dumper_registry'));
        }, [ConsoleExtension::TAG_COMMAND => ['name' => 'complete']]);
    }
    private function registerApplicationServices(ContainerBuilder $container) : void
    {
        $container->register('application.complete', function (Container $container) {
            return new Complete($container->get(CompletionExtension::SERVICE_REGISTRY));
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\CompletionExtra\\CompletionExtraExtension', 'Phpactor\\Extension\\CompletionExtra\\CompletionExtraExtension', \false);
