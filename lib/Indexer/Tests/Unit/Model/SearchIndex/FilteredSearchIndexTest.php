<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Unit\Model\SearchIndex;

use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria\ShortNameBeginsWith;
use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
use Phpactor202301\Phpactor\Indexer\Model\Record\FunctionRecord;
use Phpactor202301\Phpactor\Indexer\Model\SearchIndex;
use Phpactor202301\Phpactor\Indexer\Model\SearchIndex\FilteredSearchIndex;
use Phpactor202301\Phpactor\Indexer\Tests\IntegrationTestCase;
use Phpactor202301\Prophecy\Argument;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class FilteredSearchIndexTest extends IntegrationTestCase
{
    use \Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
    /**
     * @var ObjectProphecy<SearchIndex>
     */
    private ObjectProphecy $innerIndex;
    private FilteredSearchIndex $index;
    protected function setUp() : void
    {
        $this->innerIndex = $this->prophesize(SearchIndex::class);
        $this->index = new FilteredSearchIndex($this->innerIndex->reveal(), [ClassRecord::RECORD_TYPE]);
    }
    public function testDecoration() : void
    {
        $this->innerIndex->search(new ShortNameBeginsWith('foobar'))->willYield([ClassRecord::fromName('Foobar')])->shouldBeCalled();
        $this->innerIndex->flush()->shouldBeCalled();
        $this->index->search(new ShortNameBeginsWith('foobar'));
        $this->index->flush();
    }
    public function testWritesRecordThatIsAllowed() : void
    {
        $this->innerIndex->write(ClassRecord::fromName('FOOBAR'))->shouldBeCalled();
        $this->index->write(ClassRecord::fromName('FOOBAR'));
    }
    public function testDoesNotWriteRecordsNotAllowed() : void
    {
        $this->innerIndex->write(Argument::any())->shouldNotBeCalled();
        $this->index->write(FunctionRecord::fromName('FOOBAR'));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Unit\\Model\\SearchIndex\\FilteredSearchIndexTest', 'Phpactor\\Indexer\\Tests\\Unit\\Model\\SearchIndex\\FilteredSearchIndexTest', \false);
