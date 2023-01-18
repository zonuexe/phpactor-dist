<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Unit\Domain\Utils;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeTransform\Domain\Utils\TextUtils;
class TextUtilsTest extends TestCase
{
    /**
     * @dataProvider provideRemoveIndentation
     */
    public function testRemoveIndentation(string $code, string $expected) : void
    {
        $this->assertEquals($expected, TextUtils::removeIndentation($code));
    }
    public function provideRemoveIndentation()
    {
        (yield ['    hello', 'hello']);
        (yield [<<<'EOT'
    hello
        world
    hello
            world
EOT
, <<<'EOT'
hello
    world
hello
        world
EOT
]);
        (yield [<<<'EOT'
hello
    hello
        world
    hello
            world
EOT
, <<<'EOT'
hello
    hello
        world
    hello
            world
EOT
]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Unit\\Domain\\Utils\\TextUtilsTest', 'Phpactor\\CodeTransform\\Tests\\Unit\\Domain\\Utils\\TextUtilsTest', \false);
