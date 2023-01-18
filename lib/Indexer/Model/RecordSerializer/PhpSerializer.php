<?php

namespace Phpactor202301\Phpactor\Indexer\Model\RecordSerializer;

use Phpactor202301\Phpactor\Indexer\Model\Record;
use Phpactor202301\Phpactor\Indexer\Model\RecordSerializer;
class PhpSerializer implements RecordSerializer
{
    public function serialize(Record $record) : string
    {
        return \serialize($record);
    }
    public function deserialize(string $data) : ?Record
    {
        return \unserialize($data);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\RecordSerializer\\PhpSerializer', 'Phpactor\\Indexer\\Model\\RecordSerializer\\PhpSerializer', \false);
