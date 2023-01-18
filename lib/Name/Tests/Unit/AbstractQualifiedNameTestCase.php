<?php

namespace Phpactor202301\Phpactor\Name\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Name\Exception\InvalidName;
use Phpactor202301\Phpactor\Name\Name;
use Phpactor202301\Phpactor\Name\QualifiedName;
abstract class AbstractQualifiedNameTestCase extends TestCase
{
    /**
     * @dataProvider provideCreateFromArray
     */
    public function testCreateFromArray(array $parts, string $expected) : void
    {
        $this->assertEquals($expected, $this->createFromArray($parts));
    }
    public function provideCreateFromArray()
    {
        (yield [['Hello'], 'Hello']);
        (yield [['Hello', 'Goodbye'], 'Phpactor202301\\Hello\\Goodbye']);
    }
    /**
     * @dataProvider provideCreateFromString
     */
    public function testCreateFromString(string $string, string $expected) : void
    {
        $this->assertEquals($expected, $this->createFromString($string));
    }
    public function provideCreateFromString()
    {
        (yield ['\\Hello', 'Hello']);
        (yield ['Hello\\', 'Hello']);
        (yield ['Hello', 'Hello']);
        (yield ['Phpactor202301\\Hello\\Goodbye', 'Phpactor202301\\Hello\\Goodbye']);
    }
    public function testThrowsExceptionIfNameIsEmpty() : void
    {
        $this->expectException(InvalidName::class);
        QualifiedName::fromString('');
    }
    public function testHead() : void
    {
        $original = $this->createFromArray(['Foobar', 'Barfoo']);
        $this->assertEquals('Barfoo', $original->head()->__toString());
        $this->assertEquals('Phpactor202301\\Foobar\\Barfoo', $original->__toString());
    }
    public function testTail() : void
    {
        $original = $this->createFromArray(['Foobar', 'Barbar', 'Barfoo']);
        $this->assertEquals('Phpactor202301\\Foobar\\Barbar', $original->tail()->__toString());
        $this->assertEquals('Phpactor202301\\Foobar\\Barbar\\Barfoo', $original->__toString());
    }
    public function testIsDescendantOf() : void
    {
        $one = $this->createFromString('Phpactor202301\\One\\Two');
        $this->assertTrue($this->createFromString('Phpactor202301\\One\\Two\\Three')->isDescendantOf($one));
        $this->assertFalse($this->createFromString('Phpactor202301\\One\\Four\\Three')->isDescendantOf($one));
    }
    public function testIsCountable() : void
    {
        $this->assertCount(3, $this->createFromArray(['1', '2', '3']));
        $this->assertCount(1, $this->createFromArray(['1']));
    }
    public function testPrepend() : void
    {
        $one = $this->createFromString('Phpactor202301\\Three\\Four');
        $two = $this->createFromString('Phpactor202301\\One\\Two');
        $this->assertEquals('Phpactor202301\\One\\Two\\Three\\Four', $one->prepend($two)->__toString());
    }
    public function testAppend() : void
    {
        $one = $this->createFromString('Phpactor202301\\Three\\Four');
        $two = $this->createFromString('Phpactor202301\\One\\Two');
        $this->assertEquals('Phpactor202301\\One\\Two\\Three\\Four', $two->append($one)->__toString());
    }
    public function testToArray() : void
    {
        $this->assertEquals(['One', 'Two'], $this->createFromString('Phpactor202301\\One\\Two')->toArray());
    }
    /**
     * @return Name
     */
    protected function createFromArray(array $parts)
    {
        return QualifiedName::fromArray($parts);
    }
    /**
     * @return Name
     */
    protected function createFromString(string $string)
    {
        return QualifiedName::fromString($string);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Name\\Tests\\Unit\\AbstractQualifiedNameTestCase', 'Phpactor\\Name\\Tests\\Unit\\AbstractQualifiedNameTestCase', \false);
