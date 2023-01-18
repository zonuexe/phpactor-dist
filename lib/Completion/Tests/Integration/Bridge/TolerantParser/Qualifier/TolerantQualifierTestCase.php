<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Integration\Bridge\TolerantParser\Qualifier;

use Closure;
use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantQualifier;
use Phpactor202301\Phpactor\Completion\Tests\TestCase;
use Phpactor202301\Phpactor\TestUtils\ExtractOffset;
abstract class TolerantQualifierTestCase extends TestCase
{
    /**
     * @dataProvider provideCouldComplete
     */
    public function testCouldComplete(string $source, Closure $assertion) : void
    {
        [$source, $offset] = ExtractOffset::fromSource($source);
        $parser = new Parser();
        $root = $parser->parseSourceFile($source);
        $node = $root->getDescendantNodeAtPosition($offset);
        $assertion($this->createQualifier()->couldComplete($node));
    }
    public abstract function createQualifier() : TolerantQualifier;
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Integration\\Bridge\\TolerantParser\\Qualifier\\TolerantQualifierTestCase', 'Phpactor\\Completion\\Tests\\Integration\\Bridge\\TolerantParser\\Qualifier\\TolerantQualifierTestCase', \false);
