<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Unit\Core\LabelFormatter;

use Generator;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Completion\Core\LabelFormatter\HelpfulLabelFormatter;
class HelpfulLabelFormatterTest extends TestCase
{
    /**
     * @dataProvider provideFormat
     * @param array<string,bool> $seen
     */
    public function testFormat(string $name, array $seen, string $expected) : void
    {
        $formatter = new HelpfulLabelFormatter();
        self::assertEquals($expected, $formatter->format($name, $seen));
    }
    /**
     * @return Generator<array{string,array<string,bool>,string}>
     */
    public function provideFormat() : Generator
    {
        (yield ['Request', [], 'Request']);
        (yield ['Request', ['Request' => \true], 'Request']);
        (yield ['Phpactor202301\\Foo\\Request', ['Request' => \true], 'Request (Foo)']);
        (yield ['Phpactor202301\\PhpParser\\Node', ['Node' => \true, 'Node (Microsoft)' => \true, 'Node (Phpactor)' => \true], 'Node (PhpParser)']);
        (yield ['Phpactor202301\\Foo\\Bar\\Node', ['Node (Foo)' => \true], 'Node (Foo\\Bar)']);
        (yield ['Phpactor202301\\Foo\\Bar\\Baz\\Node', ['Node (Foo)' => \true, 'Node (Foo\\Bar)' => \true], 'Node (Foo\\Bar\\Baz)']);
        (yield 'invalid case for 2 identically named classes' => ['Phpactor202301\\Foo\\Bar\\Node', ['Node (Foo)' => \true, 'Node (Foo\\Bar)' => \true], 'Node']);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Unit\\Core\\LabelFormatter\\HelpfulLabelFormatterTest', 'Phpactor\\Completion\\Tests\\Unit\\Core\\LabelFormatter\\HelpfulLabelFormatterTest', \false);
