<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Tests\Unit\Domain\Prototype;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\TraitPrototype;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Traits;
class TraitsTest extends TestCase
{
    /**
     * @testdox Create from traits
     */
    public function testCreateFromTraits() : void
    {
        $traits = Traits::fromTraits([new TraitPrototype('One'), new TraitPrototype('Two')]);
        $this->assertCount(2, \iterator_to_array($traits));
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Tests\\Unit\\Domain\\Prototype\\TraitsTest', 'Phpactor\\CodeBuilder\\Tests\\Unit\\Domain\\Prototype\\TraitsTest', \false);
