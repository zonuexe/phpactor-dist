<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerBridge;

use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\LocationConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\TextEditConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\WorkspaceEditConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\TextDocument\FilesystemWorkspaceLocator;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\TextDocument\WorkspaceTextDocumentLocator;
use Phpactor202301\Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator\ChainDocumentLocator;
class LanguageServerBridgeExtension implements Extension
{
    public function configure(Resolver $schema) : void
    {
    }
    public function load(ContainerBuilder $container) : void
    {
        $container->register(LocationConverter::class, function (Container $container) {
            return new LocationConverter($container->get(TextDocumentLocator::class));
        });
        $container->register(TextEditConverter::class, function (Container $container) {
            return new TextEditConverter();
        });
        $container->register(WorkspaceEditConverter::class, function (Container $container) {
            return new WorkspaceEditConverter($container->get(TextDocumentLocator::class));
        });
        $container->register(FilesystemWorkspaceLocator::class, function (Container $container) {
            return new FilesystemWorkspaceLocator();
        });
        $container->register(WorkspaceTextDocumentLocator::class, function (Container $container) {
            return new WorkspaceTextDocumentLocator($container->get(LanguageServerExtension::SERVICE_SESSION_WORKSPACE));
        });
        $container->register(TextDocumentLocator::class, function (Container $container) {
            return new ChainDocumentLocator([$container->get(WorkspaceTextDocumentLocator::class), $container->get(FilesystemWorkspaceLocator::class)]);
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerBridge\\LanguageServerBridgeExtension', 'Phpactor\\Extension\\LanguageServerBridge\\LanguageServerBridgeExtension', \false);
