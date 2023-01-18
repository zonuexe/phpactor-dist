<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Virtual;

use Phpactor202301\Phpactor\WorseReflection\Core\DefaultValue;
use Phpactor202301\Phpactor\WorseReflection\Core\Position;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionFunctionLike;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionParameter;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionScope;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
class VirtualReflectionParameter implements ReflectionParameter
{
    public function __construct(private string $name, private ReflectionFunctionLike $functionLike, private Type $inferredType, private Type $type, private DefaultValue $default, private bool $byReference, private ReflectionScope $scope, private Position $position, private int $index)
    {
    }
    public function scope() : ReflectionScope
    {
        return $this->scope;
    }
    public function position() : Position
    {
        return $this->position;
    }
    public function name() : string
    {
        return $this->name;
    }
    public function method() : ReflectionFunctionLike
    {
        return $this->functionLike;
    }
    public function functionLike() : ReflectionFunctionLike
    {
        return $this->functionLike;
    }
    public function type() : Type
    {
        return $this->type;
    }
    public function inferredType() : Type
    {
        return $this->inferredType;
    }
    public function default() : DefaultValue
    {
        return $this->default;
    }
    public function byReference() : bool
    {
        return $this->byReference;
    }
    public function isPromoted() : bool
    {
        return \false;
    }
    public function isVariadic() : bool
    {
        return \false;
    }
    public function index() : int
    {
        return $this->index;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Virtual\\VirtualReflectionParameter', 'Phpactor\\WorseReflection\\Core\\Virtual\\VirtualReflectionParameter', \false);