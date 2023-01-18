<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Bridge\TolerantParser\Reflection\Collection;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionClass;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionClassLikeCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\ServiceLocator;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
class ReflectionClassCollectionTest extends TestCase
{
    use ProphecyTrait;
    private $serviceLocator;
    private $reflection1;
    private $reflection2;
    private $reflection3;
    protected function setUp() : void
    {
        $this->serviceLocator = $this->prophesize(ServiceLocator::class);
        $this->reflection1 = $this->prophesize(ReflectionClass::class);
        $this->reflection2 = $this->prophesize(ReflectionClass::class);
        $this->reflection3 = $this->prophesize(ReflectionClass::class);
    }
    /**
     * @testdox It returns only concrete classes.
     */
    public function testConcrete() : void
    {
        $this->reflection1->isConcrete()->willReturn(\false);
        $this->reflection2->isConcrete()->willReturn(\true);
        $this->reflection3->isConcrete()->willReturn(\false);
        $collection = ReflectionClassLikeCollection::fromReflections([$this->reflection1->reveal(), $this->reflection2->reveal(), $this->reflection3->reveal()]);
        $this->assertCount(1, $collection->concrete());
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Bridge\\TolerantParser\\Reflection\\Collection\\ReflectionClassCollectionTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Bridge\\TolerantParser\\Reflection\\Collection\\ReflectionClassCollectionTest', \false);
