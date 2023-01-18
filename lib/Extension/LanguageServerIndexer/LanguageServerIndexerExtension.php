<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerIndexer;

use Phpactor202301\Phpactor\AmpFsWatch\Watcher;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\LanguageServerIndexer\Handler\IndexerHandler;
use Phpactor202301\Phpactor\Extension\LanguageServerIndexer\Handler\WorkspaceSymbolHandler;
use Phpactor202301\Phpactor\Extension\LanguageServerIndexer\Listener\IndexerListener;
use Phpactor202301\Phpactor\Extension\LanguageServerIndexer\Model\WorkspaceSymbolProvider;
use Phpactor202301\Phpactor\Extension\LanguageServerIndexer\Status\IndexerStatusProvider;
use Phpactor202301\Phpactor\Extension\LanguageServerIndexer\Watcher\LanguageServerWatcher;
use Phpactor202301\Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Indexer\Extension\IndexerExtension;
use Phpactor202301\Phpactor\Indexer\Model\Indexer;
use Phpactor202301\Phpactor\Indexer\Model\SearchClient;
use Phpactor202301\Phpactor\LanguageServerProtocol\ClientCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Core\Service\ServiceManager;
use Phpactor202301\Phpactor\LanguageServer\WorkDoneProgress\ProgressNotifier;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;
use Phpactor202301\Psr\EventDispatcher\EventDispatcherInterface;
class LanguageServerIndexerExtension implements Extension
{
    public const WORKSPACE_SYMBOL_SEARCH_LIMIT = 'language_server_indexer.workspace_symbol_search_limit';
    public function load(ContainerBuilder $container) : void
    {
        $this->registerSessionHandler($container);
        $container->register(WorkspaceSymbolHandler::class, function (Container $container) {
            return new WorkspaceSymbolHandler(new WorkspaceSymbolProvider($container->get(SearchClient::class), $container->get(TextDocumentLocator::class), $container->getParameter(self::WORKSPACE_SYMBOL_SEARCH_LIMIT)));
        }, [LanguageServerExtension::TAG_METHOD_HANDLER => []]);
        $container->register(LanguageServerWatcher::class, function (Container $container) {
            return new LanguageServerWatcher($container->has(ClientCapabilities::class) ? $container->get(ClientCapabilities::class) : null);
        }, [IndexerExtension::TAG_WATCHER => ['name' => 'lsp'], LanguageServerExtension::TAG_LISTENER_PROVIDER => []]);
        $container->register(IndexerStatusProvider::class, function (Container $container) {
            return new IndexerStatusProvider($container->get(Watcher::class));
        }, [LanguageServerExtension::TAG_STATUS_PROVIDER => []]);
    }
    public function configure(Resolver $schema) : void
    {
        $schema->setDefaults([self::WORKSPACE_SYMBOL_SEARCH_LIMIT => 250]);
    }
    private function registerSessionHandler(ContainerBuilder $container) : void
    {
        $container->register(IndexerHandler::class, function (Container $container) {
            return new IndexerHandler($container->get(Indexer::class), $container->get(Watcher::class), $container->get(ClientApi::class), LoggingExtension::channelLogger($container, 'lspindexer'), $container->get(EventDispatcherInterface::class), $container->get(ProgressNotifier::class));
        }, [LanguageServerExtension::TAG_METHOD_HANDLER => [], LanguageServerExtension::TAG_SERVICE_PROVIDER => []]);
        $container->register(IndexerListener::class, function (Container $container) {
            return new IndexerListener($container->get(ServiceManager::class));
        }, [LanguageServerExtension::TAG_LISTENER_PROVIDER => []]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerIndexer\\LanguageServerIndexerExtension', 'Phpactor\\Extension\\LanguageServerIndexer\\LanguageServerIndexerExtension', \false);
