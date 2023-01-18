<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\DefaultValue;
class DefaultValueTest extends TestCase
{
    /**
     * @testdox It creates an undefined default value.
     */
    public function testNone() : void
    {
        $value = DefaultValue::undefined();
        $this->assertFalse($value->isDefined());
    }
    /**
     * @testdox It represents a value
     */
    public function testValue() : void
    {
        $value = DefaultValue::fromValue(42);
        $this->assertEquals(42, $value->value());
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\DefaultValueTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\DefaultValueTest', \false);
