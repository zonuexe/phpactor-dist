<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Adapter\Tolerant;

use Phpactor202301\Phpactor\Indexer\Model\Indexer;
use Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\TolerantIndexer;
use Phpactor202301\Phpactor\Indexer\Model\TestIndexAgent;
use Phpactor202301\Phpactor\Indexer\Tests\IntegrationTestCase;
class TolerantIndexerTestCase extends IntegrationTestCase
{
    protected function runIndexer(TolerantIndexer $indexer, string $path) : TestIndexAgent
    {
        // run the indexer twice - the results should not be affected
        $this->doRunIndexer($indexer, $path);
        return $this->doRunIndexer($indexer, $path);
    }
    private function doRunIndexer(TolerantIndexer $indexer, string $path) : TestIndexAgent
    {
        $agent = $this->indexAgentBuilder('src')->setIndexers([$indexer])->buildTestAgent();
        $agent->indexer()->getJob()->run();
        return $agent;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Adapter\\Tolerant\\TolerantIndexerTestCase', 'Phpactor\\Indexer\\Tests\\Adapter\\Tolerant\\TolerantIndexerTestCase', \false);
