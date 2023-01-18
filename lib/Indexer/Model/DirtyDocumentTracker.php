<?php

namespace Phpactor202301\Phpactor\Indexer\Model;

use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
interface DirtyDocumentTracker
{
    public function markDirty(TextDocumentUri $uri) : void;
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\DirtyDocumentTracker', 'Phpactor\\Indexer\\Model\\DirtyDocumentTracker', \false);
