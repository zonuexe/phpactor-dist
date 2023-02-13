<?php

namespace Phpactor\WorseReflection\Bridge\TolerantParser\Reflection;

use Phpactor\WorseReflection\Core\Reflection\ReflectionFunctionLike;
use Phpactor\WorseReflection\Core\ServiceLocator;
use PhpactorDist\Microsoft\PhpParser\Node\Parameter;
use Phpactor\WorseReflection\Core\Type;
use PhpactorDist\Microsoft\PhpParser\Node;
use Phpactor\WorseReflection\Core\DefaultValue;
use Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor\WorseReflection\Core\Reflection\ReflectionParameter as CoreReflectionParameter;
use Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\TypeResolver\DeclaredMemberTypeResolver;
use Phpactor\WorseReflection\Core\Reflection\TypeResolver\ParameterTypeResolver;
use Phpactor\WorseReflection\Core\Type\ArrayType;
use Phpactor\WorseReflection\TypeUtil;
class ReflectionParameter extends \Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\AbstractReflectedNode implements CoreReflectionParameter
{
    private DeclaredMemberTypeResolver $memberTypeResolver;
    public function __construct(private ServiceLocator $serviceLocator, private ReflectionFunctionLike $functionLike, private Parameter $parameter, private int $index)
    {
        $this->memberTypeResolver = new DeclaredMemberTypeResolver($serviceLocator->reflector());
    }
    public function name() : string
    {
        if (null === $this->parameter->getName()) {
            $this->serviceLocator->logger()->warning(\sprintf('Parameter has no variable at offset "%s"', $this->parameter->getStartPosition()));
            return '';
        }
        return $this->parameter->getName();
    }
    public function type() : Type
    {
        $className = $this->functionLike instanceof \Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionMethod ? $this->functionLike->class()->name() : null;
        $type = $this->memberTypeResolver->resolve($this->parameter, $this->parameter->typeDeclarationList, $className, $this->parameter->questionToken ? \true : \false);
        if ($this->parameter->dotDotDotToken) {
            return new ArrayType(null, $type);
        }
        return $type;
    }
    public function inferredType() : Type
    {
        return (new ParameterTypeResolver($this))->resolve();
    }
    public function default() : DefaultValue
    {
        if (null === $this->parameter->default) {
            return DefaultValue::undefined();
        }
        $value = $this->serviceLocator->symbolContextResolver()->resolveNode(new Frame('test'), $this->parameter->default)->type();
        return DefaultValue::fromValue(TypeUtil::valueOrNull($value));
    }
    public function byReference() : bool
    {
        return (bool) $this->parameter->byRefToken;
    }
    /**
     * @deprecated use functionLike instead
     */
    public function method() : ReflectionFunctionLike
    {
        return $this->functionLike;
    }
    public function functionLike() : ReflectionFunctionLike
    {
        return $this->functionLike;
    }
    public function isPromoted() : bool
    {
        return $this->parameter->visibilityToken !== null;
    }
    public function isVariadic() : bool
    {
        return $this->parameter->dotDotDotToken !== null;
    }
    public function index() : int
    {
        return $this->index;
    }
    protected function node() : Node
    {
        return $this->parameter;
    }
    protected function serviceLocator() : ServiceLocator
    {
        return $this->serviceLocator;
    }
}
