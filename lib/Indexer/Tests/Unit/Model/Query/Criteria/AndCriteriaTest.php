<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Unit\Model\Query\Criteria;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria\FalseCriteria;
use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria\TrueCriteria;
use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
class AndCriteriaTest extends TestCase
{
    public function testAll() : void
    {
        self::assertTrue(Criteria::and(new TrueCriteria(), new TrueCriteria(), new TrueCriteria())->isSatisfiedBy(ClassRecord::fromName('foo')));
    }
    public function testNotAllTrue() : void
    {
        self::assertFalse(Criteria::and(new TrueCriteria(), new FalseCriteria(), new TrueCriteria())->isSatisfiedBy(ClassRecord::fromName('foo')));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Unit\\Model\\Query\\Criteria\\AndCriteriaTest', 'Phpactor\\Indexer\\Tests\\Unit\\Model\\Query\\Criteria\\AndCriteriaTest', \false);
