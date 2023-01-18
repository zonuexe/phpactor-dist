<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Unit\Model\Query\Criteria;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record\MemberRecord;
class ShortNameContainsTest extends TestCase
{
    public function testContains() : void
    {
        self::assertTrue(Criteria::shortNameContains('foobar')->isSatisfiedBy(MemberRecord::fromIdentifier('method#foobar')));
        self::assertTrue(Criteria::shortNameContains('ooba')->isSatisfiedBy(MemberRecord::fromIdentifier('method#foobar')));
        self::assertTrue(Criteria::shortNameContains('OoBa')->isSatisfiedBy(MemberRecord::fromIdentifier('method#foobar')), 'Case insensitive');
        self::assertFalse(Criteria::shortNameContains('foobar')->isSatisfiedBy(MemberRecord::fromIdentifier('method#barfoo')));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Unit\\Model\\Query\\Criteria\\ShortNameContainsTest', 'Phpactor\\Indexer\\Tests\\Unit\\Model\\Query\\Criteria\\ShortNameContainsTest', \false);
