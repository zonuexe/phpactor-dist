<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Tests\Unit\Domain\Prototype;

use InvalidArgumentException;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Collection;
use stdClass;
class CollectionTest extends TestCase
{
    public function testGetThrowsException() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unknown test "foo", known items');
        $collection = TestCollection::fromArray(['one' => new stdClass()]);
        $collection->get('foo');
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Tests\\Unit\\Domain\\Prototype\\CollectionTest', 'Phpactor\\CodeBuilder\\Tests\\Unit\\Domain\\Prototype\\CollectionTest', \false);
/**
 * @extends Collection<stdClass>
 */
class TestCollection extends Collection
{
    public static function fromArray(array $items)
    {
        return new self($items);
    }
    protected function singularName() : string
    {
        return 'test';
    }
}
/**
 * @extends Collection<stdClass>
 */
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Tests\\Unit\\Domain\\Prototype\\TestCollection', 'Phpactor\\CodeBuilder\\Tests\\Unit\\Domain\\Prototype\\TestCollection', \false);
