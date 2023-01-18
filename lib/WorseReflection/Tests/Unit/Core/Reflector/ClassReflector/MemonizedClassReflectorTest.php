<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core\Reflector\ClassReflector;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\Cache\TtlCache;
use Phpactor202301\Phpactor\WorseReflection\Core\Name;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\ClassReflector;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\ClassReflector\MemonizedReflector;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\ConstantReflector;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\FunctionReflector;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
class MemonizedClassReflectorTest extends TestCase
{
    use ProphecyTrait;
    /**
     * @var ClassReflector|ObjectProphecy
     */
    private $innerClassReflector;
    /**
     * @var MemonizedClassReflector
     */
    private MemonizedReflector $reflector;
    /**
     * @var ObjectProphecy|FunctionReflector
     */
    private $innerFunctionReflector;
    private ClassName $className;
    public function setUp() : void
    {
        $this->innerClassReflector = $this->prophesize(ClassReflector::class);
        $this->innerFunctionReflector = $this->prophesize(FunctionReflector::class);
        $this->innerConstantReflector = $this->prophesize(ConstantReflector::class);
        $this->reflector = new MemonizedReflector($this->innerClassReflector->reveal(), $this->innerFunctionReflector->reveal(), $this->innerConstantReflector->reveal(), new TtlCache(10));
        $this->className = ClassName::fromString('Hello');
    }
    public function testReflectClass() : void
    {
        $this->innerClassReflector->reflectClass($this->className)->shouldBeCalledTimes(1);
        $this->reflector->reflectClass($this->className);
        $this->reflector->reflectClass($this->className);
        $this->reflector->reflectClass($this->className);
    }
    public function testReflectInterface() : void
    {
        $this->innerClassReflector->reflectInterface($this->className, [])->shouldBeCalledTimes(1);
        $this->reflector->reflectInterface($this->className);
        $this->reflector->reflectInterface($this->className);
        $this->reflector->reflectInterface($this->className);
    }
    public function testReflectTrait() : void
    {
        $this->innerClassReflector->reflectTrait($this->className, [])->shouldBeCalledTimes(1);
        $this->reflector->reflectTrait($this->className);
        $this->reflector->reflectTrait($this->className);
        $this->reflector->reflectTrait($this->className);
    }
    public function testReflectClassLike() : void
    {
        $this->innerClassReflector->reflectClassLike($this->className, [])->shouldBeCalledTimes(1);
        $this->reflector->reflectClassLike($this->className);
        $this->reflector->reflectClassLike($this->className);
        $this->reflector->reflectClassLike($this->className);
    }
    public function testReflectFunction() : void
    {
        $name = Name::fromString('Foo');
        $this->innerFunctionReflector->reflectFunction($name)->shouldBeCalledTimes(1);
        $this->reflector->reflectFunction($name);
        $this->reflector->reflectFunction($name);
        $this->reflector->reflectFunction($name);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Reflector\\ClassReflector\\MemonizedClassReflectorTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Reflector\\ClassReflector\\MemonizedClassReflectorTest', \false);
