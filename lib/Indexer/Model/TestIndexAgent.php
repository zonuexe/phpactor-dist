<?php

namespace Phpactor202301\Phpactor\Indexer\Model;

use Phpactor202301\Phpactor\Indexer\IndexAgent;
interface TestIndexAgent extends IndexAgent
{
    public function index() : Index;
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\TestIndexAgent', 'Phpactor\\Indexer\\Model\\TestIndexAgent', \false);
