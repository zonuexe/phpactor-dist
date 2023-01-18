<?php

namespace Phpactor202301\Phpactor\TextDocument\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\TextDocument\Exception\InvalidUriException;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
class TextDocumentUriTest extends TestCase
{
    public function testCreate() : void
    {
        $uri = TextDocumentUri::fromString('file://' . __FILE__);
        $this->assertEquals('file://' . __FILE__, (string) $uri);
    }
    public function testNormalizesToFileScheme() : void
    {
        $uri = TextDocumentUri::fromString(__FILE__);
        $this->assertEquals('file://' . __FILE__, (string) $uri);
    }
    public function testExceptionOnNonAbsolutePath() : void
    {
        $this->expectException(InvalidUriException::class);
        TextDocumentUri::fromString('i is relative');
    }
    public function testExceptionOnInvalidUri() : void
    {
        $this->expectException(InvalidUriException::class);
        $this->expectExceptionMessage('not parse');
        TextDocumentUri::fromString('no:///this:isnot/ && !');
    }
    public function testExceptionOnNoPath() : void
    {
        $this->expectException(InvalidUriException::class);
        $this->expectExceptionMessage('has no path');
        TextDocumentUri::fromString('file://foo');
    }
    public function testFromPath() : void
    {
        $uri = TextDocumentUri::fromString('/foobar');
        $this->assertEquals('file:///foobar', $uri->__toString());
    }
    public function testFromHttpUri() : void
    {
        $this->expectException(InvalidUriException::class);
        $this->expectExceptionMessage('Only "file://" scheme is supported, got "http"');
        $uri = TextDocumentUri::fromString('http://foobar/foobar');
    }
    public function testReturnsPath() : void
    {
        $uri = TextDocumentUri::fromString('file://' . __FILE__);
        $this->assertEquals(__FILE__, $uri->path());
    }
    public function testScheme() : void
    {
        $uri = TextDocumentUri::fromString('file://' . __FILE__);
        $this->assertEquals('file', $uri->scheme());
    }
}
\class_alias('Phpactor202301\\Phpactor\\TextDocument\\Tests\\Unit\\TextDocumentUriTest', 'Phpactor\\TextDocument\\Tests\\Unit\\TextDocumentUriTest', \false);
