<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Unit\Model\Query\Criteria;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
use Phpactor202301\Phpactor\Indexer\Model\Record\FunctionRecord;
class IsFunctionTest extends TestCase
{
    public function testIsFunction() : void
    {
        self::assertFalse(Criteria::isFunction()->isSatisfiedBy(ClassRecord::fromName('foobar')));
        self::assertTrue(Criteria::isFunction()->isSatisfiedBy(FunctionRecord::fromName('foobar')));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Unit\\Model\\Query\\Criteria\\IsFunctionTest', 'Phpactor\\Indexer\\Tests\\Unit\\Model\\Query\\Criteria\\IsFunctionTest', \false);
