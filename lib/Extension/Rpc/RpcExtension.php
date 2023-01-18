<?php

namespace Phpactor202301\Phpactor\Extension\Rpc;

use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\Debug\DebugExtension;
use Phpactor202301\Phpactor\Extension\Debug\Model\DefinitionDocumentor;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\Console\ConsoleExtension;
use Phpactor202301\Phpactor\Extension\Rpc\Command\RpcCommand;
use Phpactor202301\Phpactor\Extension\Rpc\Handler\EchoHandler;
use Phpactor202301\Phpactor\Extension\Rpc\Registry\LazyContainerHandlerRegistry;
use Phpactor202301\Phpactor\Extension\Rpc\RequestHandler\ExceptionCatchingHandler;
use Phpactor202301\Phpactor\Extension\Rpc\RequestHandler\LoggingHandler;
use Phpactor202301\Phpactor\Extension\Rpc\RequestHandler\RequestHandler;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use RuntimeException;
class RpcExtension implements Extension
{
    public const TAG_RPC_HANDLER = 'rpc.handler';
    public const SERVICE_REQUEST_HANDLER = 'rpc.request_handler';
    public const RPC_DOCUMENTOR_NAME = 'rpc';
    private const STORE_REPLAY = 'rpc.store_replay';
    private const REPLAY_PATH = 'rpc.replay_path';
    public function load(ContainerBuilder $container) : void
    {
        $container->register('rpc.command.rpc', function (Container $container) {
            return new RpcCommand($container->get('rpc.request_handler'), $container->get(FilePathResolverExtension::SERVICE_FILE_PATH_RESOLVER)->resolve($container->getParameter('rpc.replay_path')), $container->getParameter('rpc.store_replay'));
        }, [ConsoleExtension::TAG_COMMAND => ['name' => 'rpc']]);
        $container->register(self::SERVICE_REQUEST_HANDLER, function (Container $container) {
            return new LoggingHandler(new ExceptionCatchingHandler(new RequestHandler($container->get('rpc.handler_registry'))), LoggingExtension::channelLogger($container, 'rpc'));
        });
        $container->register('rpc.handler_registry', function (Container $container) {
            $handlers = [];
            foreach ($container->getServiceIdsForTag(self::TAG_RPC_HANDLER) as $serviceId => $attrs) {
                if (!isset($attrs['name'])) {
                    throw new RuntimeException(\sprintf('Handler "%s" must be provided with a "name" ' . 'attribute when it is registered', $serviceId));
                }
                $handlers[$attrs['name']] = $serviceId;
            }
            return new LazyContainerHandlerRegistry($container, $handlers);
        });
        $container->register(RpcCommandDocumentor::class, function ($container) {
            return new RpcCommandDocumentor($container->get('rpc.handler_registry'), $container->get(DefinitionDocumentor::class));
        }, [DebugExtension::TAG_DOCUMENTOR => ['name' => self::RPC_DOCUMENTOR_NAME]]);
        $this->registerHandlers($container);
    }
    public function configure(Resolver $schema) : void
    {
        $schema->setDefaults([self::STORE_REPLAY => \false, self::REPLAY_PATH => '%cache%/replay.json']);
        $schema->setDescriptions([self::STORE_REPLAY => 'Should replays be stored?', self::REPLAY_PATH => 'Path where the replays should be stored']);
    }
    private function registerHandlers(ContainerBuilder $container) : void
    {
        $container->register('rpc.handler.echo', function (Container $container) {
            return new EchoHandler();
        }, [self::TAG_RPC_HANDLER => ['name' => 'echo']]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\RpcExtension', 'Phpactor\\Extension\\Rpc\\RpcExtension', \false);
