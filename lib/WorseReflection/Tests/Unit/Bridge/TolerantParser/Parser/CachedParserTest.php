<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Bridge\TolerantParser\Parser;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Parser\CachedParser;
use Phpactor202301\Phpactor\WorseReflection\Core\Cache\TtlCache;
class CachedParserTest extends TestCase
{
    public function testCachesResults() : void
    {
        $parser = new CachedParser(new TtlCache());
        $node1 = $parser->parseSourceFile(\file_get_contents(__FILE__));
        $node2 = $parser->parseSourceFile(\file_get_contents(__FILE__));
        $this->assertSame($node1, $node2);
    }
    public function testReturnsDifferentResultsForDifferentSourceCodes() : void
    {
        $parser = new CachedParser(new TtlCache());
        $node1 = $parser->parseSourceFile(\file_get_contents(__FILE__));
        $node2 = $parser->parseSourceFile('Foobar' . \file_get_contents(__FILE__));
        $this->assertNotSame($node1, $node2);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Bridge\\TolerantParser\\Parser\\CachedParserTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Bridge\\TolerantParser\\Parser\\CachedParserTest', \false);
