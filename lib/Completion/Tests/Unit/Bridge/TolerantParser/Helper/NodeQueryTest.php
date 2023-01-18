<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Unit\Bridge\TolerantParser\Helper;

use Closure;
use Generator;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\DelimitedList\ArgumentExpressionList;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ArgumentExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ObjectCreationExpression;
use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\Helper\NodeQuery;
use Phpactor202301\Phpactor\TestUtils\ExtractOffset;
class NodeQueryTest extends TestCase
{
    private Parser $parser;
    protected function setUp() : void
    {
        $this->parser = new Parser();
    }
    /**
     * @dataProvider provideFirstAncestorVia
     */
    public function testFirstAncestorVia(string $source, Closure $assertion) : void
    {
        $node = $this->nodeFromSource($source);
        $assertion($node);
    }
    /**
     * @return Generator<mixed>
     */
    public function provideFirstAncestorVia() : Generator
    {
        (yield ['<?php new Barfoo(new Foobar($foo, $ba<>));', function (Node $node) : void {
            $node = NodeQuery::firstAncestorVia($node, ObjectCreationExpression::class, [ArgumentExpression::class, ArgumentExpressionList::class]);
            self::assertNotNull($node);
            self::assertInstanceOf(ObjectCreationExpression::class, $node);
            self::assertEquals('Foobar', $node->classTypeDesignator->getText());
        }]);
        (yield ['<?php new Barfoo(new Foobar($foo, array_map($ba<>, [])));', function (Node $node) : void {
            $node = NodeQuery::firstAncestorVia($node, ObjectCreationExpression::class, [ArgumentExpression::class, ArgumentExpressionList::class]);
            self::assertNull($node);
        }]);
    }
    private function nodeFromSource(string $source) : Node
    {
        [$source, $offset] = ExtractOffset::fromSource($source);
        return $this->parser->parseSourceFile($source)->getDescendantNodeAtPosition($offset);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Unit\\Bridge\\TolerantParser\\Helper\\NodeQueryTest', 'Phpactor\\Completion\\Tests\\Unit\\Bridge\\TolerantParser\\Helper\\NodeQueryTest', \false);
