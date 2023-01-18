<?php

namespace Phpactor202301\Phpactor\Indexer\Model;

use Phpactor202301\Phpactor\Indexer\Model\Record\FileRecord;
interface RecordReferenceEnhancer
{
    /**
     * Add additional information to the record reference, e.g. determine its
     * container type through static analysis.
     */
    public function enhance(FileRecord $record, RecordReference $reference) : RecordReference;
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\RecordReferenceEnhancer', 'Phpactor\\Indexer\\Model\\RecordReferenceEnhancer', \false);
