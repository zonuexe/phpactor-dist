<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerIndexer\Status;

use Phpactor202301\Phpactor\AmpFsWatch\Watcher;
use Phpactor202301\Phpactor\Extension\LanguageServer\Status\StatusProvider;
class IndexerStatusProvider implements StatusProvider
{
    public function __construct(private Watcher $watcher)
    {
    }
    public function title() : string
    {
        return 'Indexer';
    }
    public function provide() : array
    {
        return ['watcher' => $this->watcher->describe()];
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerIndexer\\Status\\IndexerStatusProvider', 'Phpactor\\Extension\\LanguageServerIndexer\\Status\\IndexerStatusProvider', \false);
