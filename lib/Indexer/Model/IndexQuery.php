<?php

namespace Phpactor202301\Phpactor\Indexer\Model;

interface IndexQuery
{
    /**
     * @return Record|null
     */
    public function get(string $identifier);
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\IndexQuery', 'Phpactor\\Indexer\\Model\\IndexQuery', \false);
