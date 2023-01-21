<?php

namespace Phpactor\Indexer\Model;

interface SearchIndex extends \Phpactor\Indexer\Model\SearchClient
{
    public function write(\Phpactor\Indexer\Model\Record $record) : void;
    public function remove(\Phpactor\Indexer\Model\Record $record) : void;
    public function flush() : void;
}
