<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection;

use Phpactor202301\Microsoft\PhpParser\Node\ConstElement;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMember;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\ServiceLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionConstant as CoreReflectionConstant;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Microsoft\PhpParser\Node\ClassConstDeclaration;
use Phpactor202301\Phpactor\WorseReflection\TypeUtil;
class ReflectionConstant extends AbstractReflectionClassMember implements CoreReflectionConstant
{
    public function __construct(private ServiceLocator $serviceLocator, private ReflectionClassLike $class, private ClassConstDeclaration $declaration, private ConstElement $node)
    {
    }
    public function name() : string
    {
        return (string) $this->node->getName();
    }
    public function nameRange() : ByteOffsetRange
    {
        return ByteOffsetRange::fromInts($this->node->name->getStartPosition(), $this->node->name->getEndPosition());
    }
    public function type() : Type
    {
        $value = $this->serviceLocator->symbolContextResolver()->resolveNode(new Frame('test'), $this->node->assignment);
        return $value->type();
    }
    public function class() : ReflectionClassLike
    {
        return $this->class;
    }
    public function inferredType() : Type
    {
        if (TypeFactory::unknown() !== $this->type()) {
            return $this->type();
        }
        return TypeFactory::undefined();
    }
    public function isVirtual() : bool
    {
        return \false;
    }
    public function value()
    {
        return TypeUtil::valueOrNull($this->serviceLocator()->symbolContextResolver()->resolveNode(new Frame('_'), $this->node->assignment)->type());
    }
    public function memberType() : string
    {
        return ReflectionMember::TYPE_CONSTANT;
    }
    public function withClass(ReflectionClassLike $class) : ReflectionMember
    {
        return new self($this->serviceLocator, $class, $this->declaration, $this->node);
    }
    public function isStatic() : bool
    {
        return \true;
    }
    protected function node() : Node
    {
        return $this->declaration;
    }
    protected function serviceLocator() : ServiceLocator
    {
        return $this->serviceLocator;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionConstant', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionConstant', \false);
