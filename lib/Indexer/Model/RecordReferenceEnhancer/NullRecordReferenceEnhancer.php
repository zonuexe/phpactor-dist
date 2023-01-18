<?php

namespace Phpactor202301\Phpactor\Indexer\Model\RecordReferenceEnhancer;

use Phpactor202301\Phpactor\Indexer\Model\RecordReference;
use Phpactor202301\Phpactor\Indexer\Model\RecordReferenceEnhancer;
use Phpactor202301\Phpactor\Indexer\Model\Record\FileRecord;
class NullRecordReferenceEnhancer implements RecordReferenceEnhancer
{
    public function enhance(FileRecord $record, RecordReference $reference) : RecordReference
    {
        return $reference;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\RecordReferenceEnhancer\\NullRecordReferenceEnhancer', 'Phpactor\\Indexer\\Model\\RecordReferenceEnhancer\\NullRecordReferenceEnhancer', \false);
