<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Unit\Adapter\Php\Serialized;

use Phpactor202301\PHPUnit\Framework\Assert;
use Phpactor202301\Phpactor\Indexer\Adapter\Php\Serialized\FileRepository;
use Phpactor202301\Phpactor\Indexer\Adapter\Php\Serialized\SerializedIndex;
use Phpactor202301\Phpactor\Indexer\Model\RecordSerializer\PhpSerializer;
use Phpactor202301\Phpactor\Indexer\Tests\IntegrationTestCase;
use SplFileInfo;
class SerializedIndexTest extends IntegrationTestCase
{
    public function testIsFreshWithNonExistingFile() : void
    {
        $repo = new FileRepository($this->workspace()->path(), new PhpSerializer());
        $index = new SerializedIndex($repo);
        $info = new SplFileInfo($this->workspace()->path('no'));
        Assert::assertFalse($index->isFresh($info), 'File doesn\'t exist, so its not fresh');
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Unit\\Adapter\\Php\\Serialized\\SerializedIndexTest', 'Phpactor\\Indexer\\Tests\\Unit\\Adapter\\Php\\Serialized\\SerializedIndexTest', \false);
