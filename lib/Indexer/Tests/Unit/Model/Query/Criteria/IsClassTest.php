<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Unit\Model\Query\Criteria;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
use Phpactor202301\Phpactor\Indexer\Model\Record\FunctionRecord;
class IsClassTest extends TestCase
{
    public function testIsClass() : void
    {
        self::assertTrue(Criteria::isClass()->isSatisfiedBy(ClassRecord::fromName('foobar')));
        self::assertFalse(Criteria::isClass()->isSatisfiedBy(FunctionRecord::fromName('foobar')));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Unit\\Model\\Query\\Criteria\\IsClassTest', 'Phpactor\\Indexer\\Tests\\Unit\\Model\\Query\\Criteria\\IsClassTest', \false);
