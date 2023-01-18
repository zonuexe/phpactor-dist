<?php

namespace Phpactor202301\Phpactor\Indexer\Model\SearchClient;

use Generator;
use Phpactor202301\Phpactor\Indexer\Model\Index;
use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\SearchClient;
class HydratingSearchClient implements SearchClient
{
    public function __construct(private Index $index, private SearchClient $innerClient)
    {
    }
    public function search(Criteria $criteria) : Generator
    {
        foreach ($this->innerClient->search($criteria) as $record) {
            (yield $this->index->get($record));
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\SearchClient\\HydratingSearchClient', 'Phpactor\\Indexer\\Model\\SearchClient\\HydratingSearchClient', \false);
