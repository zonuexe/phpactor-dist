<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\Position;
class PositionTest extends TestCase
{
    /**
     * @testdox It provides width
     */
    public function testWidth() : void
    {
        $position = Position::fromFullStartStartAndEnd(10, 15, 35);
        $this->assertEquals(10, $position->fullStart());
        $this->assertEquals(15, $position->start());
        $this->assertEquals(35, $position->end());
        $this->assertEquals(20, $position->width());
        $this->assertEquals(25, $position->fullWidth());
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\PositionTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\PositionTest', \false);
