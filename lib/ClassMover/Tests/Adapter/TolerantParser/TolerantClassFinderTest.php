<?php

namespace Phpactor202301\Phpactor\ClassMover\Tests\Adapter\TolerantParser;

use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Phpactor\ClassMover\Adapter\TolerantParser\TolerantClassFinder;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
class TolerantClassFinderTest extends TestCase
{
    /**
     * @testdox It finds all class references.
     */
    public function testFind() : void
    {
        $parser = new Parser();
        $tolerantRefFinder = new TolerantClassFinder($parser);
        $source = TextDocumentBuilder::fromUri(__DIR__ . '/examples/Example1.php')->build();
        $names = \iterator_to_array($tolerantRefFinder->findIn($source));
        $this->assertCount(8, $names);
        $this->assertEquals('Phpactor202301\\Acme\\Foobar\\Warble', $names[0]->__toString());
        $this->assertEquals('Phpactor202301\\Acme\\Foobar\\Barfoo', $names[1]->__toString());
        $this->assertEquals('Phpactor202301\\Acme\\Barfoo', $names[2]->__toString());
        $this->assertEquals('Phpactor202301\\Acme\\Hello', $names[3]->__toString());
        $this->assertEquals('Phpactor202301\\Acme\\Foobar\\Warble', $names[4]->__toString());
        $this->assertEquals('Phpactor202301\\Acme\\Demo', $names[5]->__toString());
        $this->assertEquals('Phpactor202301\\Acme\\Foobar\\Barfoo', $names[6]->__toString());
        $this->assertEquals('Phpactor202301\\Acme\\Foobar\\Barfoo', $names[7]->__toString());
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Tests\\Adapter\\TolerantParser\\TolerantClassFinderTest', 'Phpactor\\ClassMover\\Tests\\Adapter\\TolerantParser\\TolerantClassFinderTest', \false);
