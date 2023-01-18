<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerSymbolProvider;

use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\LanguageServerSymbolProvider\Adapter\TolerantDocumentSymbolProvider;
use Phpactor202301\Phpactor\Extension\LanguageServerSymbolProvider\Handler\DocumentSymbolProviderHandler;
use Phpactor202301\Phpactor\Extension\LanguageServerSymbolProvider\Model\DocumentSymbolProvider;
use Phpactor202301\Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
class LanguageServerSymbolProviderExtension implements Extension
{
    public function load(ContainerBuilder $container) : void
    {
        $container->register(DocumentSymbolProviderHandler::class, function (Container $container) {
            return new DocumentSymbolProviderHandler($container->get(LanguageServerExtension::SERVICE_SESSION_WORKSPACE), $container->get(DocumentSymbolProvider::class));
        }, [LanguageServerExtension::TAG_METHOD_HANDLER => []]);
        $container->register(DocumentSymbolProvider::class, function (Container $container) {
            return new TolerantDocumentSymbolProvider(new Parser());
        });
    }
    public function configure(Resolver $schema) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerSymbolProvider\\LanguageServerSymbolProviderExtension', 'Phpactor\\Extension\\LanguageServerSymbolProvider\\LanguageServerSymbolProviderExtension', \false);
