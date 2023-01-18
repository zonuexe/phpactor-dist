<?php

namespace Phpactor202301\Phpactor\Indexer\Model;

use Phpactor202301\Phpactor\Indexer\Model\DirtyDocumentTracker\NullDirtyDocumentTracker;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class Indexer
{
    private DirtyDocumentTracker $dirtyDocumentTracker;
    public function __construct(private IndexBuilder $builder, private Index $index, private FileListProvider $provider, ?DirtyDocumentTracker $dirtyDocumentTracker = null)
    {
        $this->dirtyDocumentTracker = $dirtyDocumentTracker ?: new NullDirtyDocumentTracker();
    }
    public function getJob(?string $subPath = null) : IndexJob
    {
        return new IndexJob($this->builder, $this->provider->provideFileList($this->index, $subPath));
    }
    public function index(TextDocument $textDocument) : void
    {
        $this->builder->index($textDocument);
    }
    /**
     * Index a file but mark it as dirty so that it will be reloaded from disk on the next indexing run.
     */
    public function indexDirty(TextDocument $textDocument) : void
    {
        $this->dirtyDocumentTracker->markDirty($textDocument->uri());
        $this->builder->index($textDocument);
    }
    public function reset() : void
    {
        $this->index->reset();
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Indexer', 'Phpactor\\Indexer\\Model\\Indexer', \false);
