<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core\Reflection\Collection;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\HomogeneousReflectionMemberCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMember;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Visibility;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClass;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\Position;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class HomogeneousReflectionMemberCollectionTest extends TestCase
{
    use ProphecyTrait;
    /**
     * @var ObjectProphecy|ReflectionMember
     */
    private $member1;
    /**
     * @var ObjectProphecy|ReflectionMember
     */
    private $member2;
    /**
     * @var ObjectProphecy|ReflectionMember
     */
    private ObjectProphecy $member3;
    public function setUp() : void
    {
        $this->member1 = $this->prophesize(ReflectionMember::class);
        $this->member2 = $this->prophesize(ReflectionMember::class);
        $this->member3 = $this->prophesize(ReflectionMember::class);
    }
    public function testByVisibilities() : void
    {
        $collection = $this->create([$this->member1->reveal(), $this->member2->reveal(), $this->member3->reveal()]);
        $this->member1->visibility()->willReturn(Visibility::public());
        $this->member2->visibility()->willReturn(Visibility::private());
        $this->member3->visibility()->willReturn(Visibility::public());
        $collection = $collection->byVisibilities([Visibility::public()]);
        $this->assertCount(2, $collection);
    }
    public function testBelongingTo() : void
    {
        $collection = $this->create([$this->member1->reveal(), $this->member2->reveal(), $this->member3->reveal()]);
        $class1 = $this->prophesize(ReflectionClass::class);
        $class2 = $this->prophesize(ReflectionClass::class);
        $class1->name()->willReturn(ClassName::fromString('foo'));
        $class2->name()->willReturn(ClassName::fromString('bar'));
        $this->member1->declaringClass()->willReturn($class1->reveal());
        $this->member2->declaringClass()->willReturn($class2->reveal());
        $this->member3->declaringClass()->willReturn($class1->reveal());
        $collection = $collection->belongingTo(ClassName::fromString('foo'));
        $this->assertCount(2, $collection);
    }
    public function testAtOffset() : void
    {
        $collection = $this->create([$this->member1->reveal(), $this->member2->reveal(), $this->member3->reveal()]);
        $this->member1->position()->willReturn(Position::fromStartAndEnd(0, 10));
        $this->member2->position()->willReturn(Position::fromStartAndEnd(11, 11));
        $this->member3->position()->willReturn(Position::fromStartAndEnd(13, 16));
        $collection = $collection->atOffset(11);
        $this->assertCount(1, $collection);
    }
    public function testByName() : void
    {
        $collection = $this->create(['foo' => $this->member1->reveal(), 'bar' => $this->member2->reveal()]);
        $this->member1->name()->willReturn('foo');
        $collection = $collection->byName('foo');
        $this->assertCount(1, $collection);
        $collection = $collection->byName('bar');
        $this->assertCount(0, $collection);
    }
    private function create(array $members) : ReflectionMemberCollection
    {
        return HomogeneousReflectionMemberCollection::fromReflections($members);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Reflection\\Collection\\HomogeneousReflectionMemberCollectionTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Reflection\\Collection\\HomogeneousReflectionMemberCollectionTest', \false);