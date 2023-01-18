<?php

namespace Phpactor202301\Phpactor\ReferenceFinder\Tests\Unit\Search;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\ReferenceFinder\Search\NameSearchResult;
use Phpactor202301\Phpactor\ReferenceFinder\Search\NameSearchResultType;
use RuntimeException;
class NameSearchResultTest extends TestCase
{
    public function testThrowsExceptionOnInvalidType() : void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('is invalid');
        NameSearchResult::create('foobar', 'Foobar');
    }
    public function testCreateClassResult() : void
    {
        $result = NameSearchResult::create(NameSearchResultType::TYPE_CLASS, 'Foobar');
        self::assertInstanceOf(NameSearchResult::class, $result);
        self::assertTrue($result->type()->isClass());
    }
    public function testCreateFunctionResult() : void
    {
        $result = NameSearchResult::create(NameSearchResultType::TYPE_FUNCTION, 'Foobar');
        self::assertInstanceOf(NameSearchResult::class, $result);
        self::assertTrue($result->type()->isFunction());
    }
}
\class_alias('Phpactor202301\\Phpactor\\ReferenceFinder\\Tests\\Unit\\Search\\NameSearchResultTest', 'Phpactor\\ReferenceFinder\\Tests\\Unit\\Search\\NameSearchResultTest', \false);
