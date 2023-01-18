<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Unit\Model\Query\Criteria;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
use Phpactor202301\Phpactor\Indexer\Model\Record\MemberRecord;
class IsMemberTest extends TestCase
{
    public function testIsFunction() : void
    {
        self::assertFalse(Criteria::isMember()->isSatisfiedBy(ClassRecord::fromName('foobar')));
        self::assertTrue(Criteria::isMember()->isSatisfiedBy(MemberRecord::fromIdentifier('method#barfoo')));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Unit\\Model\\Query\\Criteria\\IsMemberTest', 'Phpactor\\Indexer\\Tests\\Unit\\Model\\Query\\Criteria\\IsMemberTest', \false);
