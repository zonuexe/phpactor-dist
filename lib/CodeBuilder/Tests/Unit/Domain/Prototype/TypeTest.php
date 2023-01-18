<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Tests\Unit\Domain\Prototype;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Type;
class TypeTest extends TestCase
{
    /**
     * @dataProvider provideNamespace
     */
    public function testItReturnsANamespace(string $classFqn, string $expectedNamespace = null) : void
    {
        $type = Type::fromString($classFqn);
        $this->assertEquals($expectedNamespace, $type->namespace());
    }
    public function provideNamespace()
    {
        (yield ['Phpactor202301\\Foo\\Bar', 'Foo']);
        (yield ['Phpactor202301\\Foo\\Bar\\Zoo', 'Phpactor202301\\Foo\\Bar']);
        (yield ['Phpactor202301\\Foo\\Bar\\Zoo\\Zog', 'Phpactor202301\\Foo\\Bar\\Zoo']);
        (yield ['?Foo\\Bar', 'Foo']);
        (yield ['?Bar', null]);
        (yield ['Bar', null]);
        (yield ['', null]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Tests\\Unit\\Domain\\Prototype\\TypeTest', 'Phpactor\\CodeBuilder\\Tests\\Unit\\Domain\\Prototype\\TypeTest', \false);
