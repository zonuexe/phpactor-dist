<?php

namespace Phpactor202301\Phpactor\Indexer\Model;

interface SearchIndex extends SearchClient
{
    public function write(Record $record) : void;
    public function remove(Record $record) : void;
    public function flush() : void;
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\SearchIndex', 'Phpactor\\Indexer\\Model\\SearchIndex', \false);
