<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Benchmark;

use Phpactor202301\Phpactor\Indexer\Adapter\Php\FileSearchIndex;
use Phpactor202301\Phpactor\Indexer\IndexAgentBuilder;
use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria\ShortNameBeginsWith;
use Phpactor202301\Phpactor\Indexer\Model\SearchClient;
/**
 * Run ./bin/console index:build before running this benchmark
 *
 * @Iterations(10)
 * @Revs(1)
 * @OutputTimeUnit("time")
 */
class SearchBench
{
    private SearchClient $search;
    public function createBareFileSearch() : void
    {
        $indexPath = __DIR__ . '/../..';
        $this->search = new FileSearchIndex($indexPath . '/cache/search');
    }
    public function createFullFileSearch() : void
    {
        $indexPath = __DIR__ . '/../../cache';
        $this->search = IndexAgentBuilder::create($indexPath, __DIR__ . '/../../')->buildAgent()->search();
    }
    /**
     * @BeforeMethods({"createBareFileSearch"})
     * @ParamProviders({"provideSearches"})
     */
    public function benchBareFileSearch(array $params) : void
    {
        foreach ($this->search->search(new ShortNameBeginsWith($params['search'])) as $result) {
        }
    }
    /**
     * @BeforeMethods({"createFullFileSearch"})
     * F
     * @ParamProviders({"provideSearches"})
     */
    public function benchFullFileSearch(array $params) : void
    {
        foreach ($this->search->search(new ShortNameBeginsWith($params['search'])) as $result) {
        }
    }
    public function provideSearches()
    {
        (yield 'A' => ['search' => 'A']);
        (yield 'Request' => ['search' => 'Request']);
    }
}
/**
 * Run ./bin/console index:build before running this benchmark
 *
 * @Iterations(10)
 * @Revs(1)
 * @OutputTimeUnit("time")
 */
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Benchmark\\SearchBench', 'Phpactor\\Indexer\\Tests\\Benchmark\\SearchBench', \false);
