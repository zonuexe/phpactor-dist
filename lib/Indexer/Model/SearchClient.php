<?php

namespace Phpactor202301\Phpactor\Indexer\Model;

use Generator;
use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
interface SearchClient
{
    /**
     * @return Generator<Record>
     */
    public function search(Criteria $criteria) : Generator;
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\SearchClient', 'Phpactor\\Indexer\\Model\\SearchClient', \false);
