<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Unit\Model\Query\Criteria;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria\ExactShortName;
use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
class ExactShortNameTest extends TestCase
{
    public function testNotMatchesEmpty() : void
    {
        $record = ClassRecord::fromName('Phpactor202301\\Foobar\\Barfoo');
        self::assertFalse(Criteria::exactShortName('')->isSatisfiedBy($record));
    }
    public function testMatches() : void
    {
        $record = ClassRecord::fromName('Phpactor202301\\Foobar\\Barfoo');
        self::assertTrue((new ExactShortName('Barfoo'))->isSatisfiedBy($record));
    }
    public function testNotMatches() : void
    {
        $record = ClassRecord::fromName('Phpactor202301\\Foobar\\Bazfoo');
        self::assertFalse((new ExactShortName('Barfoo'))->isSatisfiedBy($record));
    }
    public function testNotMatchesPartial() : void
    {
        $record = ClassRecord::fromName('Phpactor202301\\Foobar\\Barfoos');
        self::assertFalse((new ExactShortName('Barfoo'))->isSatisfiedBy($record));
    }
    public function testMatchesGlobal() : void
    {
        $record = ClassRecord::fromName('Barfoo');
        self::assertTrue((new ExactShortName('Barfoo'))->isSatisfiedBy($record));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Unit\\Model\\Query\\Criteria\\ExactShortNameTest', 'Phpactor\\Indexer\\Tests\\Unit\\Model\\Query\\Criteria\\ExactShortNameTest', \false);
