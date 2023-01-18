<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Unit\Model\Record;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Indexer\Model\Record\MemberRecord;
use RuntimeException;
class MemberRecordTest extends TestCase
{
    public function testExceptionOnInvalidIdentifier() : void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Invalid member identifier');
        MemberRecord::fromIdentifier('member');
    }
    public function testExceptionOnInvalidType() : void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Invalid member type');
        MemberRecord::fromIdentifier('asd#member');
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Unit\\Model\\Record\\MemberRecordTest', 'Phpactor\\Indexer\\Tests\\Unit\\Model\\Record\\MemberRecordTest', \false);
