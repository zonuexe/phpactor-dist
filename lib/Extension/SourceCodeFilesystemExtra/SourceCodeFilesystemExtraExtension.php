<?php

namespace Phpactor202301\Phpactor\Extension\SourceCodeFilesystemExtra;

use Phpactor202301\Phpactor\Extension\Console\ConsoleExtension;
use Phpactor202301\Phpactor\Extension\Rpc\RpcExtension;
use Phpactor202301\Phpactor\Extension\SourceCodeFilesystemExtra\Rpc\ClassSearchHandler;
use Phpactor202301\Phpactor\Extension\SourceCodeFilesystem\SourceCodeFilesystemExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\Extension\SourceCodeFilesystemExtra\Command\ClassSearchCommand;
use Phpactor202301\Phpactor\Extension\SourceCodeFilesystemExtra\SourceCodeFilestem\Application\ClassSearch;
class SourceCodeFilesystemExtraExtension implements Extension
{
    public function configure(Resolver $schema) : void
    {
    }
    public function load(ContainerBuilder $container) : void
    {
        $this->registerCommands($container);
        $this->registerApplicationServices($container);
        $this->registerRpc($container);
    }
    private function registerCommands(ContainerBuilder $container) : void
    {
        $container->register('command.class_search', function (Container $container) {
            return new ClassSearchCommand($container->get('application.class_search'), $container->get('console.dumper_registry'));
        }, [ConsoleExtension::TAG_COMMAND => ['name' => 'class:search']]);
    }
    private function registerApplicationServices(ContainerBuilder $container) : void
    {
        $container->register('application.class_search', function (Container $container) {
            return new ClassSearch($container->get('source_code_filesystem.registry'), $container->get('class_to_file.converter'), $container->get(WorseReflectionExtension::SERVICE_REFLECTOR));
        });
    }
    private function registerRpc(ContainerBuilder $container) : void
    {
        $container->register('source_code_filesystem.rpc.handler.class_search', function (Container $container) {
            return new ClassSearchHandler($container->get('application.class_search'), SourceCodeFilesystemExtension::FILESYSTEM_COMPOSER);
        }, [RpcExtension::TAG_RPC_HANDLER => ['name' => ClassSearchHandler::NAME]]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\SourceCodeFilesystemExtra\\SourceCodeFilesystemExtraExtension', 'Phpactor\\Extension\\SourceCodeFilesystemExtra\\SourceCodeFilesystemExtraExtension', \false);
