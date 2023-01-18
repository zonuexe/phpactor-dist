<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Tests\Functional\Adapter\TolerantParser\Util;

use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeBuilder\Adapter\TolerantParser\Util\NodeHelper;
use Phpactor202301\Phpactor\TestUtils\ExtractOffset;
class NodeHelperTest extends TestCase
{
    private Parser $parser;
    protected function setUp() : void
    {
        $this->parser = new Parser();
    }
    public function testSelf() : void
    {
        [$methodNode, $nameNode] = $this->findSelfNode();
        $result = NodeHelper::resolvedShortName($methodNode, $nameNode);
        $this->assertEquals('self', $result);
    }
    private function findSelfNode()
    {
        [$source, $methodOffset, $nameOffset] = ExtractOffset::fromSource('<?php class Foobar { public function f<>oo(): sel<>f() { return $this; }}');
        $root = $this->parser->parseSourceFile($source);
        return [$root->getDescendantNodeAtPosition($methodOffset), $root->getDescendantNodeAtPosition($nameOffset)];
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Tests\\Functional\\Adapter\\TolerantParser\\Util\\NodeHelperTest', 'Phpactor\\CodeBuilder\\Tests\\Functional\\Adapter\\TolerantParser\\Util\\NodeHelperTest', \false);
