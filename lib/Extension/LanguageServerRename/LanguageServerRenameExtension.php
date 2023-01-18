<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerRename;

use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\LanguageServerRename\Handler\FileRenameHandler;
use Phpactor202301\Phpactor\Rename\Model\FileRenamer;
use Phpactor202301\Phpactor\Rename\Model\Renamer\ChainRenamer;
use Phpactor202301\Phpactor\Extension\LanguageServerRename\Handler\RenameHandler;
use Phpactor202301\Phpactor\Rename\Model\Renamer;
use Phpactor202301\Phpactor\Extension\LanguageServerRename\Util\LocatedTextEditConverter;
use Phpactor202301\Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;
class LanguageServerRenameExtension implements Extension
{
    public const TAG_RENAMER = 'language_server_rename.renamer';
    public function load(ContainerBuilder $container) : void
    {
        $container->register(Renamer::class, function (Container $container) {
            return new ChainRenamer(\array_map(function (string $serviceId) use($container) {
                return $container->get($serviceId);
            }, \array_keys($container->getServiceIdsForTag(self::TAG_RENAMER))));
        });
        $container->register(RenameHandler::class, function (Container $container) {
            return new RenameHandler($container->get(LocatedTextEditConverter::class), $container->get(TextDocumentLocator::class), $container->get(Renamer::class), $container->get(ClientApi::class));
        }, [LanguageServerExtension::TAG_METHOD_HANDLER => []]);
        $container->register(FileRenameHandler::class, function (Container $container) {
            return new FileRenameHandler($container->get(FileRenamer::class), $container->get(LocatedTextEditConverter::class));
        }, [LanguageServerExtension::TAG_METHOD_HANDLER => []]);
        $container->register(LocatedTextEditConverter::class, function (Container $container) {
            return new LocatedTextEditConverter($container->get(LanguageServerExtension::SERVICE_SESSION_WORKSPACE), $container->get(TextDocumentLocator::class));
        });
    }
    public function configure(Resolver $schema) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerRename\\LanguageServerRenameExtension', 'Phpactor\\Extension\\LanguageServerRename\\LanguageServerRenameExtension', \false);
