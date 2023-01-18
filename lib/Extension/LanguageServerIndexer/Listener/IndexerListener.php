<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerIndexer\Listener;

use Generator;
use Phpactor202301\Phpactor\Extension\LanguageServerIndexer\Event\IndexReset;
use Phpactor202301\Phpactor\Extension\LanguageServerIndexer\Handler\IndexerHandler;
use Phpactor202301\Phpactor\LanguageServer\Core\Service\ServiceManager;
use Phpactor202301\Phpactor\LanguageServer\Event\WillShutdown;
use Phpactor202301\Psr\EventDispatcher\ListenerProviderInterface;
class IndexerListener implements ListenerProviderInterface
{
    public function __construct(private ServiceManager $manager)
    {
    }
    /**
     * @return Generator<callable>
     */
    public function getListenersForEvent(object $event) : iterable
    {
        if ($event instanceof IndexReset) {
            (yield function () : void {
                if ($this->manager->isRunning(IndexerHandler::SERVICE_INDEXER)) {
                    $this->manager->stop(IndexerHandler::SERVICE_INDEXER);
                }
                $this->manager->start(IndexerHandler::SERVICE_INDEXER);
            });
        }
        if ($event instanceof WillShutdown) {
            if ($this->manager->isRunning(IndexerHandler::SERVICE_INDEXER)) {
                $this->manager->stop(IndexerHandler::SERVICE_INDEXER);
            }
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerIndexer\\Listener\\IndexerListener', 'Phpactor\\Extension\\LanguageServerIndexer\\Listener\\IndexerListener', \false);
