<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core\Virtual;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\DefaultValue;
use Phpactor202301\Phpactor\WorseReflection\Core\Position;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClass;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMethod;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionParameter;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionScope;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Virtual\VirtualReflectionParameter;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class VirtualReflectionParameterTest extends TestCase
{
    use ProphecyTrait;
    private $position;
    private ObjectProphecy $class;
    private string $name;
    private ObjectProphecy $frame;
    private ObjectProphecy $scope;
    private Type $type;
    private ObjectProphecy $method;
    private DefaultValue $defaults;
    public function setUp() : void
    {
        $this->position = Position::fromStartAndEnd(0, 0);
        $this->class = $this->prophesize(ReflectionClass::class);
        $this->name = 'test_name';
        $this->scope = $this->prophesize(ReflectionScope::class);
        $this->type = TypeFactory::unknown();
        $this->method = $this->prophesize(ReflectionMethod::class);
        $this->defaults = DefaultValue::fromValue(1234);
        $this->byReference = \false;
    }
    public function parameter() : ReflectionParameter
    {
        return new VirtualReflectionParameter($this->name, $this->method->reveal(), $this->type, $this->type, $this->defaults, $this->byReference, $this->scope->reveal(), $this->position, 0);
    }
    public function testAccess() : void
    {
        $parameter = $this->parameter();
        $this->assertEquals($this->name, $parameter->name());
        $this->assertEquals($this->method->reveal(), $parameter->functionLike());
        $this->assertEquals($this->method->reveal(), $parameter->method());
        $this->assertEquals($this->type, $parameter->inferredType());
        $this->assertEquals($this->type, $parameter->type());
        $this->assertEquals($this->defaults, $parameter->default());
        $this->assertEquals($this->byReference, $parameter->byReference());
        $this->assertEquals($this->scope->reveal(), $parameter->scope());
        $this->assertEquals($this->position, $parameter->position());
        $this->assertEquals(0, $parameter->index());
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Virtual\\VirtualReflectionParameterTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Virtual\\VirtualReflectionParameterTest', \false);
