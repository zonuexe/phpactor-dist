<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Unit\Model\Query\Criteria;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
class FileAbsolutePathBeginsWithTest extends TestCase
{
    public function testDoesNotBeginWith() : void
    {
        $record = ClassRecord::fromName('Phpactor202301\\Foobar\\Barfoo')->setFilePath('/foobar');
        self::assertFalse(Criteria::fileAbsolutePathBeginsWith('/baz')->isSatisfiedBy($record));
    }
    public function testBeginsWith() : void
    {
        $record = ClassRecord::fromName('Phpactor202301\\Foobar\\Barfoo')->setFilePath('/foobar/bazboo/baz.php');
        self::assertTrue(Criteria::fileAbsolutePathBeginsWith('/foobar')->isSatisfiedBy($record));
    }
    public function testBeginsWithTrailingSlash() : void
    {
        $record = ClassRecord::fromName('Phpactor202301\\Foobar\\Barfoo')->setFilePath('/foobar/bazboo/baz.php');
        self::assertTrue(Criteria::fileAbsolutePathBeginsWith('/foobar/')->isSatisfiedBy($record));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Unit\\Model\\Query\\Criteria\\FileAbsolutePathBeginsWithTest', 'Phpactor\\Indexer\\Tests\\Unit\\Model\\Query\\Criteria\\FileAbsolutePathBeginsWithTest', \false);
