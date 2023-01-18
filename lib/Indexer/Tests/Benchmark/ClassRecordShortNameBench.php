<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Benchmark;

use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
/**
 * @Iterations(33)
 * @Revs(1000)
 * @OutputTimeUnit("microseconds")
 */
class ClassRecordShortNameBench
{
    private ClassRecord $record;
    public function createClassRecord() : void
    {
        $this->record = ClassRecord::fromName('Phpactor202301\\Barfoo\\Foobar');
    }
    /**
     * @BeforeMethods({"createClassRecord"})
     */
    public function benchShortName() : void
    {
        $this->record->shortName();
    }
}
/**
 * @Iterations(33)
 * @Revs(1000)
 * @OutputTimeUnit("microseconds")
 */
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Benchmark\\ClassRecordShortNameBench', 'Phpactor\\Indexer\\Tests\\Benchmark\\ClassRecordShortNameBench', \false);
