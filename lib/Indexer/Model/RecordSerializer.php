<?php

namespace Phpactor\Indexer\Model;

interface RecordSerializer
{
    public function serialize(\Phpactor\Indexer\Model\Record $record) : string;
    public function deserialize(string $data) : ?\Phpactor\Indexer\Model\Record;
}
