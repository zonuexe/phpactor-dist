<?php

namespace Phpactor202301\Phpactor\Indexer\Model;

use Phpactor202301\Phpactor\Indexer\IndexAgent;
class RealIndexAgent implements IndexAgent, TestIndexAgent
{
    public function __construct(private Index $index, private QueryClient $query, private SearchClient $search, private Indexer $indexer)
    {
    }
    public function search() : SearchClient
    {
        return $this->search;
    }
    public function query() : QueryClient
    {
        return $this->query;
    }
    public function indexer() : Indexer
    {
        return $this->indexer;
    }
    public function index() : Index
    {
        return $this->index;
    }
    public function access() : IndexAccess
    {
        return $this->index;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\RealIndexAgent', 'Phpactor\\Indexer\\Model\\RealIndexAgent', \false);
