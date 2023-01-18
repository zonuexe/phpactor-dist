<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Adapter\Php;

use Phpactor202301\Phpactor\Indexer\Adapter\Php\FileSearchIndex;
use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria\ShortNameBeginsWith;
use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
use Phpactor202301\Phpactor\Indexer\Tests\IntegrationTestCase;
class FileSearchIndexTest extends IntegrationTestCase
{
    private FileSearchIndex $index;
    protected function setUp() : void
    {
        $this->workspace()->reset();
        $this->index = new FileSearchIndex($this->workspace()->path('search'));
    }
    public function testWriteIndex() : void
    {
        $record = ClassRecord::fromName('Foobar');
        $this->index->write($record);
        $this->index->flush();
        $this->assertCount(1, $this->search('Foobar'));
    }
    public function testWriteIndexMultipleTimesDoesNotIncreaseSearchResultNumber() : void
    {
        $record = ClassRecord::fromName('Foobar');
        $this->index->write($record);
        $this->index->write($record);
        $this->index->write($record);
        $this->index->write($record);
        $this->index->flush();
        $this->assertCount(1, $this->search('Foobar'));
    }
    public function testMultipleResultsForPartialMatch() : void
    {
        $record = ClassRecord::fromName('Foobar');
        $this->index->write($record);
        $record = ClassRecord::fromName('Foostar');
        $this->index->write($record);
        $this->index->flush();
        $this->assertCount(2, $this->search('Foo'));
    }
    private function search(string $query) : array
    {
        return \iterator_to_array($this->index->search(new ShortNameBeginsWith($query)));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Adapter\\Php\\FileSearchIndexTest', 'Phpactor\\Indexer\\Tests\\Adapter\\Php\\FileSearchIndexTest', \false);
