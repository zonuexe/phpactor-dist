<?php

namespace Phpactor202301\Phpactor\Indexer\Model;

interface Record
{
    /**
     * Return string which is unique to this record (used for namespacing),
     * e.g. "class".
     */
    public function recordType() : string;
    /**
     * Return a unique identifier for this record.
     */
    public function identifier() : string;
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Record', 'Phpactor\\Indexer\\Model\\Record', \false);
