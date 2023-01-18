<?php

namespace Phpactor202301\Phpactor\Indexer;

use Phpactor202301\Phpactor\Indexer\Model\IndexAccess;
use Phpactor202301\Phpactor\Indexer\Model\QueryClient;
use Phpactor202301\Phpactor\Indexer\Model\Indexer;
use Phpactor202301\Phpactor\Indexer\Model\SearchClient;
interface IndexAgent
{
    public function search() : SearchClient;
    public function query() : QueryClient;
    public function indexer() : Indexer;
    public function access() : IndexAccess;
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\IndexAgent', 'Phpactor\\Indexer\\IndexAgent', \false);
