<?php

namespace Phpactor202301\Phpactor\FilePathResolver\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\FilePathResolver\Exception\UnknownToken;
use Phpactor202301\Phpactor\FilePathResolver\Expander\ValueExpander;
use Phpactor202301\Phpactor\FilePathResolver\Expanders;
class ExpandersTest extends TestCase
{
    public function testProvidesArrayRepresentation() : void
    {
        $expanders = new Expanders([new ValueExpander('foo', 'bar'), new ValueExpander('bar', 'foo')]);
        $this->assertEquals(['foo' => 'bar', 'bar' => 'foo'], $expanders->toArray());
    }
    public function testThrowsExceptionIfUnknownTokenFound() : void
    {
        $this->expectException(UnknownToken::class);
        $expanders = new Expanders([new ValueExpander('foo', 'bar'), new ValueExpander('bar', 'foo')]);
        $expanders->get('baz');
    }
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\Tests\\Unit\\ExpandersTest', 'Phpactor\\FilePathResolver\\Tests\\Unit\\ExpandersTest', \false);
