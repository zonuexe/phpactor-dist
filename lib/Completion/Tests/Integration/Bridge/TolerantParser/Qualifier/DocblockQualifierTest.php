<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Integration\Bridge\TolerantParser\Qualifier;

use Generator;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\Qualifier\DocblockQualifier;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantQualifier;
class DocblockQualifierTest extends TolerantQualifierTestCase
{
    public function provideCouldComplete() : Generator
    {
        (yield 'no docblock' => ['<?php $hello<>', function (?Node $node) : void {
            $this->assertNull($node);
        }]);
        (yield 'docblock' => ['<?php /** @foo */$hello<>', function (?Node $node) : void {
            self::assertInstanceOf(Node::class, $node);
        }]);
    }
    public function createQualifier() : TolerantQualifier
    {
        return new DocblockQualifier();
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Integration\\Bridge\\TolerantParser\\Qualifier\\DocblockQualifierTest', 'Phpactor\\Completion\\Tests\\Integration\\Bridge\\TolerantParser\\Qualifier\\DocblockQualifierTest', \false);
