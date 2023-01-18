<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core\Virtual;

use Phpactor202301\Phpactor\WorseReflection\Core\Deprecation;
use Phpactor202301\Phpactor\WorseReflection\Core\NodeText;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionParameterCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMember;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMethod;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Virtual\VirtualReflectionMethod;
class VirtualReflectionMethodTest extends VirtualReflectionMemberTestCase
{
    private $parameters;
    private $body;
    private $isAbstract;
    private $isStatic;
    public function setUp() : void
    {
        parent::setUp();
        $this->parameters = ReflectionParameterCollection::empty();
        $this->body = NodeText::fromString('hello');
        $this->isAbstract = \true;
        $this->isStatic = \true;
    }
    /**
     * @return ReflectionMethod
     */
    public function member() : ReflectionMember
    {
        return new VirtualReflectionMethod($this->position, $this->declaringClass->reveal(), $this->class->reveal(), $this->name, $this->frame->reveal(), $this->docblock->reveal(), $this->scope->reveal(), $this->visibility, $this->type, $this->type, $this->parameters, $this->body, $this->isAbstract, $this->isStatic, new Deprecation(\false));
    }
    public function testParameters() : void
    {
        $this->assertEquals($this->parameters, $this->member()->parameters());
    }
    public function testBody() : void
    {
        $this->assertEquals($this->body, $this->member()->body());
    }
    public function testIsAbstract() : void
    {
        $this->assertEquals($this->isAbstract, $this->member()->isAbstract());
    }
    public function testIsStatic() : void
    {
        $this->assertEquals($this->isStatic, $this->member()->isStatic());
    }
    public function testVirtual() : void
    {
        $this->assertTrue($this->member()->isStatic());
    }
    public function testReturnType() : void
    {
        $this->assertEquals(TypeFactory::unknown(), $this->member()->returnType());
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Virtual\\VirtualReflectionMethodTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Virtual\\VirtualReflectionMethodTest', \false);
