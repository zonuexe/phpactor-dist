<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Tests\Unit\Domain\Prototype;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Docblock;
class DocblockTest extends TestCase
{
    /**
     * @testdox It returns docblock as lines.
     */
    public function testAsLines() : void
    {
        $this->assertEquals([''], Docblock::fromString('')->asLines());
        $this->assertEquals(['One', 'Two'], Docblock::fromString(<<<'EOT'
One
Two
EOT
)->asLines());
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Tests\\Unit\\Domain\\Prototype\\DocblockTest', 'Phpactor\\CodeBuilder\\Tests\\Unit\\Domain\\Prototype\\DocblockTest', \false);
