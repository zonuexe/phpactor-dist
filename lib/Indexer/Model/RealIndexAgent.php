<?php

namespace Phpactor\Indexer\Model;

use Phpactor\Indexer\IndexAgent;
class RealIndexAgent implements IndexAgent, \Phpactor\Indexer\Model\TestIndexAgent
{
    public function __construct(private \Phpactor\Indexer\Model\Index $index, private \Phpactor\Indexer\Model\QueryClient $query, private \Phpactor\Indexer\Model\SearchClient $search, private \Phpactor\Indexer\Model\Indexer $indexer)
    {
    }
    public function search() : \Phpactor\Indexer\Model\SearchClient
    {
        return $this->search;
    }
    public function query() : \Phpactor\Indexer\Model\QueryClient
    {
        return $this->query;
    }
    public function indexer() : \Phpactor\Indexer\Model\Indexer
    {
        return $this->indexer;
    }
    public function index() : \Phpactor\Indexer\Model\Index
    {
        return $this->index;
    }
    public function access() : \Phpactor\Indexer\Model\IndexAccess
    {
        return $this->index;
    }
}
