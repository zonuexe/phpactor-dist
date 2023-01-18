<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerBlackfire;

use Phpactor202301\Blackfire\Client;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\OptionalExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerBlackfire\Handler\BlackfireHandler;
use Phpactor202301\Phpactor\Extension\LanguageServerBlackfire\Middleware\BlackfireMiddleware;
use Phpactor202301\Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use RuntimeException;
class LanguageServerBlackfireExtension implements OptionalExtension
{
    public function load(ContainerBuilder $container) : void
    {
        $container->register(BlackfireHandler::class, function (Container $container) {
            return new BlackfireHandler($container->get(BlackfireProfiler::class), $container->get(ClientApi::class));
        }, [LanguageServerExtension::TAG_METHOD_HANDLER => []]);
        $container->register(BlackfireProfiler::class, function (Container $container) {
            if (!\class_exists(Client::class)) {
                throw new RuntimeException('Blackfire blackfire/php-sdk package is not installed, maybe you need to ensure Phpactor is installed with dev dependencies?');
            }
            return new BlackfireProfiler(new Client());
        });
        $container->register(BlackfireMiddleware::class, function (Container $container) {
            return new BlackfireMiddleware($container->get(BlackfireProfiler::class));
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
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerBlackfire\\LanguageServerBlackfireExtension', 'Phpactor\\Extension\\LanguageServerBlackfire\\LanguageServerBlackfireExtension', \false);
