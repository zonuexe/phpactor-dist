<?php

namespace Phpactor202301\Phpactor\Indexer\Model\DirtyDocumentTracker;

use Phpactor202301\Phpactor\Indexer\Model\DirtyDocumentTracker;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
class NullDirtyDocumentTracker implements DirtyDocumentTracker
{
    public function markDirty(TextDocumentUri $uri) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\DirtyDocumentTracker\\NullDirtyDocumentTracker', 'Phpactor\\Indexer\\Model\\DirtyDocumentTracker\\NullDirtyDocumentTracker', \false);
