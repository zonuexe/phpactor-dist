<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Unit\Model\Query\Criteria;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
class FqnBeginsWithTest extends TestCase
{
    public function testNotMatchesEmpty() : void
    {
        $record = ClassRecord::fromName('Phpactor202301\\Foobar\\Barfoo');
        self::assertTrue(Criteria::fqnBeginsWith('Foobar')->isSatisfiedBy($record));
    }
    public function testMatchesExact() : void
    {
        $record = ClassRecord::fromName('Phpactor202301\\Foobar\\Barfoo');
        self::assertTrue(Criteria::fqnBeginsWith('Phpactor202301\\Foobar\\Barfoo')->isSatisfiedBy($record));
    }
    public function testNotMatches() : void
    {
        $record = ClassRecord::fromName('Phpactor202301\\Foobar\\Bazfoo');
        self::assertFalse(Criteria::fqnBeginsWith('Barfoo')->isSatisfiedBy($record));
    }
    public function testMatchesPartialBeginingWith() : void
    {
        $record = ClassRecord::fromName('Phpactor202301\\Foobar\\Barfoos');
        self::assertTrue(Criteria::fqnBeginsWith('Foo')->isSatisfiedBy($record));
    }
    public function testNotMatchesPartialEndsWith() : void
    {
        $record = ClassRecord::fromName('Phpactor202301\\Foobar\\abBarfoo');
        self::assertFalse(Criteria::fqnBeginsWith('Barfoo')->isSatisfiedBy($record));
    }
    public function testMatchesGlobal() : void
    {
        $record = ClassRecord::fromName('Barfoo');
        self::assertTrue(Criteria::fqnBeginsWith('Barfoo')->isSatisfiedBy($record));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Unit\\Model\\Query\\Criteria\\FqnBeginsWithTest', 'Phpactor\\Indexer\\Tests\\Unit\\Model\\Query\\Criteria\\FqnBeginsWithTest', \false);
