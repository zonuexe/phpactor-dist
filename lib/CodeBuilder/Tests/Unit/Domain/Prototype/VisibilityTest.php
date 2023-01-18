<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Tests\Unit\Domain\Prototype;

use InvalidArgumentException;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Visibility;
class VisibilityTest extends TestCase
{
    /**
     * @testdox It throws an exception if an invalid visiblity is given.
     */
    public function testException() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid visibility');
        Visibility::fromString('foobar');
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Tests\\Unit\\Domain\\Prototype\\VisibilityTest', 'Phpactor\\CodeBuilder\\Tests\\Unit\\Domain\\Prototype\\VisibilityTest', \false);
