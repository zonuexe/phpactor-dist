<?php

namespace Phpactor202301\Phpactor\Indexer\Model;

interface RecordSerializer
{
    public function serialize(Record $record) : string;
    public function deserialize(string $data) : ?Record;
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\RecordSerializer', 'Phpactor\\Indexer\\Model\\RecordSerializer', \false);
