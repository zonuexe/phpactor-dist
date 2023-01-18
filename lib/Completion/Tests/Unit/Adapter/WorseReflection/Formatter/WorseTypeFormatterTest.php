<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Unit\Adapter\WorseReflection\Formatter;

use Generator;
use Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter\TypeFormatter;
use Phpactor202301\Phpactor\Completion\Tests\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\Completion\Core\Formatter\ObjectFormatter;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
class WorseTypeFormatterTest extends TestCase
{
    /**
     * @dataProvider provideFormat
     */
    public function testFormat(Type $type, string $expected) : void
    {
        $formatter = new ObjectFormatter([new TypeFormatter()]);
        $this->assertEquals($expected, $formatter->format($type));
    }
    /**
     * @return Generator<mixed>
     */
    public function provideFormat() : Generator
    {
        $reflector = ReflectorBuilder::create()->build();
        (yield 'no types' => [TypeFactory::unknown(), '<missing>']);
        (yield 'single scalar' => [TypeFactory::string(), 'string']);
        (yield 'union' => [TypeFactory::union(TypeFactory::string(), TypeFactory::null()), 'string|null']);
        (yield 'typed array' => [TypeFactory::array(TypeFactory::string()), 'string[]']);
        (yield 'generic' => [TypeFactory::collection($reflector, 'Collection', 'Item'), 'Collection<Item>']);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Unit\\Adapter\\WorseReflection\\Formatter\\WorseTypeFormatterTest', 'Phpactor\\Completion\\Tests\\Unit\\Adapter\\WorseReflection\\Formatter\\WorseTypeFormatterTest', \false);
