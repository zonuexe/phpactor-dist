<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Unit\Domain;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeTransform\Domain\Generator;
use Phpactor202301\Phpactor\CodeTransform\Domain\Generators;
class GeneratorsTest extends TestCase
{
    use \Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
    /**
     * @testdox It can retrieve and iterate generators.
     */
    public function testIterateAndRetrieve() : void
    {
        $generator1 = $this->prophesize(Generator::class);
        $generator2 = $this->prophesize(Generator::class);
        $generators = Generators::fromArray(['one' => $generator1->reveal(), 'two' => $generator2->reveal()]);
        $this->assertSame($generator1->reveal(), $generators->get('one'));
        $this->assertCount(2, $generators);
        $this->assertSame(['one' => $generator1->reveal(), 'two' => $generator2->reveal()], \iterator_to_array($generators));
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Unit\\Domain\\GeneratorsTest', 'Phpactor\\CodeTransform\\Tests\\Unit\\Domain\\GeneratorsTest', \false);
