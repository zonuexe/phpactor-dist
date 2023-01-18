<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Query;

use Phpactor202301\Phpactor\Indexer\Model\Index;
use Phpactor202301\Phpactor\Indexer\Model\IndexQuery;
use Phpactor202301\Phpactor\Indexer\Model\Record\FileRecord;
class FileQuery implements IndexQuery
{
    public function __construct(private Index $index)
    {
    }
    public function get(string $identifier) : ?FileRecord
    {
        $prototype = FileRecord::fromPath($identifier);
        return $this->index->has($prototype) ? $this->index->get($prototype) : null;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Query\\FileQuery', 'Phpactor\\Indexer\\Model\\Query\\FileQuery', \false);
