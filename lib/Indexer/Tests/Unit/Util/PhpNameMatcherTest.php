<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Unit\Util;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Indexer\Util\PhpNameMatcher;
class PhpNameMatcherTest extends TestCase
{
    public function testMatch() : void
    {
        self::assertTrue(PhpNameMatcher::isPhpName('Foobar'));
        self::assertTrue(PhpNameMatcher::isPhpName('foobar'));
        self::assertFalse(PhpNameMatcher::isPhpName('$foobar'));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Unit\\Util\\PhpNameMatcherTest', 'Phpactor\\Indexer\\Tests\\Unit\\Util\\PhpNameMatcherTest', \false);
