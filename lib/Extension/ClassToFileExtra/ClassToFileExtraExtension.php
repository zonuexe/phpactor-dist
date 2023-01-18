<?php

namespace Phpactor202301\Phpactor\Extension\ClassToFileExtra;

use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Extension\ClassToFileExtra\Rpc\FileInfoHandler;
use Phpactor202301\Phpactor\Extension\Console\ConsoleExtension;
use Phpactor202301\Phpactor\Extension\Rpc\RpcExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\Extension\ClassToFileExtra\Command\FileInfoCommand;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Extension\ClassToFileExtra\Application\FileInfo;
class ClassToFileExtraExtension implements Extension
{
    public function load(ContainerBuilder $container) : void
    {
        $container->register('command.file_info', function (Container $container) {
            return new FileInfoCommand($container->get('application.file_info'), $container->get('console.dumper_registry'));
        }, [ConsoleExtension::TAG_COMMAND => ['name' => 'file:info']]);
        $container->register('application.file_info', function (Container $container) {
            return new FileInfo($container->get('class_to_file.converter'), $container->get('source_code_filesystem.simple'));
        });
        $container->register('class_to_file_extra.rpc.handler.file_info', function (Container $container) {
            return new FileInfoHandler($container->get('application.file_info'));
        }, [RpcExtension::TAG_RPC_HANDLER => ['name' => FileInfoHandler::NAME]]);
    }
    public function configure(Resolver $schema) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ClassToFileExtra\\ClassToFileExtraExtension', 'Phpactor\\Extension\\ClassToFileExtra\\ClassToFileExtraExtension', \false);
