<?php

namespace Phpactor\Extension\LanguageServerBlackfire;

use PhpactorDist\Blackfire\Client;
use Phpactor\Container\Container;
use Phpactor\Container\ContainerBuilder;
use Phpactor\Container\OptionalExtension;
use Phpactor\Extension\LanguageServerBlackfire\Handler\BlackfireHandler;
use Phpactor\Extension\LanguageServerBlackfire\Middleware\BlackfireMiddleware;
use Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor\MapResolver\Resolver;
use RuntimeException;
class LanguageServerBlackfireExtension implements OptionalExtension
{
    public function load(ContainerBuilder $container) : void
    {
        $container->register(BlackfireHandler::class, function (Container $container) {
            return new BlackfireHandler($container->get(\Phpactor\Extension\LanguageServerBlackfire\BlackfireProfiler::class), $container->get(ClientApi::class));
        }, [LanguageServerExtension::TAG_METHOD_HANDLER => []]);
        $container->register(\Phpactor\Extension\LanguageServerBlackfire\BlackfireProfiler::class, function (Container $container) {
            if (!\class_exists(Client::class)) {
                throw new RuntimeException('Blackfire blackfire/php-sdk package is not installed, maybe you need to ensure Phpactor is installed with dev dependencies?');
            }
            return new \Phpactor\Extension\LanguageServerBlackfire\BlackfireProfiler(new Client());
        });
        $container->register(BlackfireMiddleware::class, function (Container $container) {
            return new BlackfireMiddleware($container->get(\Phpactor\Extension\LanguageServerBlackfire\BlackfireProfiler::class));
        }, [LanguageServerExtension::TAG_MIDDLEWARE => []]);
    }
    public function configure(Resolver $schema) : void
    {
    }
    public function name() : string
    {
        return 'blackfire';
    }
}
