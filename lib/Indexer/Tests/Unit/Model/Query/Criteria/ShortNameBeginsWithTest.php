<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Unit\Model\Query\Criteria;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria\ShortNameBeginsWith;
use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
class ShortNameBeginsWithTest extends TestCase
{
    public function testNotMatchesEmpty() : void
    {
        $record = ClassRecord::fromName('Phpactor202301\\Foobar\\Barfoo');
        self::assertTrue(Criteria::shortNameBeginsWith('Barfoo')->isSatisfiedBy($record));
    }
    public function testMatchesExact() : void
    {
        $record = ClassRecord::fromName('Phpactor202301\\Foobar\\Barfoo');
        self::assertTrue((new ShortNameBeginsWith('Barfoo'))->isSatisfiedBy($record));
    }
    public function testNotMatches() : void
    {
        $record = ClassRecord::fromName('Phpactor202301\\Foobar\\Bazfoo');
        self::assertFalse((new ShortNameBeginsWith('Barfoo'))->isSatisfiedBy($record));
    }
    public function testMatchesPartialBeginingWith() : void
    {
        $record = ClassRecord::fromName('Phpactor202301\\Foobar\\Barfoos');
        self::assertTrue((new ShortNameBeginsWith('Barfoo'))->isSatisfiedBy($record));
    }
    public function testNotMatchesPartialEndsWith() : void
    {
        $record = ClassRecord::fromName('Phpactor202301\\Foobar\\abBarfoo');
        self::assertFalse((new ShortNameBeginsWith('Barfoo'))->isSatisfiedBy($record));
    }
    public function testMatchesGlobal() : void
    {
        $record = ClassRecord::fromName('Barfoo');
        self::assertTrue((new ShortNameBeginsWith('Barfoo'))->isSatisfiedBy($record));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Unit\\Model\\Query\\Criteria\\ShortNameBeginsWithTest', 'Phpactor\\Indexer\\Tests\\Unit\\Model\\Query\\Criteria\\ShortNameBeginsWithTest', \false);
