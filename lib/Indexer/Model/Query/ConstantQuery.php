<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Query;

use Phpactor202301\Phpactor\Indexer\Model\Index;
use Phpactor202301\Phpactor\Indexer\Model\IndexQuery;
use Phpactor202301\Phpactor\Indexer\Model\Record\ConstantRecord;
class ConstantQuery implements IndexQuery
{
    public function __construct(private Index $index)
    {
    }
    public function get(string $identifier) : ?ConstantRecord
    {
        $prototype = ConstantRecord::fromName($identifier);
        return $this->index->has($prototype) ? $this->index->get($prototype) : null;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Query\\ConstantQuery', 'Phpactor\\Indexer\\Model\\Query\\ConstantQuery', \false);
