<?php

namespace Phpactor202301\Phpactor\Indexer\Adapter\Php\InMemory;

use Generator;
use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record;
use Phpactor202301\Phpactor\Indexer\Model\RecordFactory;
use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
use Phpactor202301\Phpactor\Indexer\Model\SearchIndex;
class InMemorySearchIndex implements SearchIndex
{
    /**
     * @var array<string,array{string,string}>
     */
    private $buffer = [];
    /**
     * @return Generator<Record>
     */
    public function search(Criteria $criteria) : Generator
    {
        foreach ($this->buffer as [$recordType, $identifier]) {
            $record = RecordFactory::create($recordType, $identifier);
            if (!$criteria->isSatisfiedBy($record)) {
                continue;
            }
            (yield $record);
        }
    }
    public function write(Record $record) : void
    {
        $this->buffer[$record->identifier()] = [$record->recordType(), $record->identifier()];
    }
    public function flush() : void
    {
    }
    public function remove(Record $record) : void
    {
        unset($this->buffer[$record->identifier()]);
    }
    public function has(ClassRecord $record) : bool
    {
        return isset($this->buffer[$record->identifier()]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Adapter\\Php\\InMemory\\InMemorySearchIndex', 'Phpactor\\Indexer\\Adapter\\Php\\InMemory\\InMemorySearchIndex', \false);
