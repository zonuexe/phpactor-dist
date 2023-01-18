<?php

namespace Phpactor202301\Phpactor\Indexer\Model\SearchIndex;

use Generator;
use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record;
use Phpactor202301\Phpactor\Indexer\Model\SearchIndex;
class FilteredSearchIndex implements SearchIndex
{
    /**
     * @param array<string> $recordTypes
     */
    public function __construct(private SearchIndex $innerIndex, private array $recordTypes)
    {
    }
    public function search(Criteria $criteria) : Generator
    {
        return $this->innerIndex->search($criteria);
    }
    public function write(Record $record) : void
    {
        if (!\in_array($record->recordType(), $this->recordTypes)) {
            return;
        }
        $this->innerIndex->write($record);
    }
    public function flush() : void
    {
        $this->innerIndex->flush();
    }
    public function remove(Record $record) : void
    {
        $this->innerIndex->remove($record);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\SearchIndex\\FilteredSearchIndex', 'Phpactor\\Indexer\\Model\\SearchIndex\\FilteredSearchIndex', \false);
