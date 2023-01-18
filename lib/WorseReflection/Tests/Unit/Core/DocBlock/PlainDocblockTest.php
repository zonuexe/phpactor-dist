<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core\DocBlock;

use Phpactor202301\Phpactor\TestUtils\PHPUnit\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\DocBlock\DocBlock;
use Phpactor202301\Phpactor\WorseReflection\Core\DocBlock\PlainDocblock;
class PlainDocblockTest extends TestCase
{
    public function testDefined() : void
    {
        self::assertFalse($this->createDocblock('')->isDefined());
        self::assertTrue($this->createDocblock('foo')->isDefined());
    }
    public function testInherits() : void
    {
        self::assertFalse($this->createDocblock('')->inherits());
        self::assertTrue($this->createDocblock('@inheritDoc')->inherits());
    }
    public function testFormatted() : void
    {
        self::assertEquals("hello world\ngoodbye world", $this->createDocblock(<<<'EOT'
    /**
     * hello world
     * goodbye world
     */

EOT
)->formatted());
    }
    private function createDocblock(string $string) : DocBlock
    {
        return new PlainDocblock($string);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\DocBlock\\PlainDocblockTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\DocBlock\\PlainDocblockTest', \false);
