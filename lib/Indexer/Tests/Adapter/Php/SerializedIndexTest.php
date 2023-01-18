<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Adapter\Php;

use Phpactor202301\Phpactor\Indexer\Adapter\Php\Serialized\FileRepository;
use Phpactor202301\Phpactor\Indexer\Adapter\Php\Serialized\SerializedIndex;
use Phpactor202301\Phpactor\Indexer\Model\Index;
use Phpactor202301\Phpactor\Indexer\Model\RecordSerializer\PhpSerializer;
use Phpactor202301\Phpactor\Indexer\Tests\Adapter\IndexTestCase;
class SerializedIndexTest extends IndexTestCase
{
    protected function createIndex() : Index
    {
        return new SerializedIndex(new FileRepository($this->workspace()->path('cache'), new PhpSerializer()));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Adapter\\Php\\SerializedIndexTest', 'Phpactor\\Indexer\\Tests\\Adapter\\Php\\SerializedIndexTest', \false);
