<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\DocBlock;

use Phpactor202301\Phpactor\WorseReflection\Core\Deprecation;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMethodCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionPropertyCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
use Phpactor202301\Phpactor\WorseReflection\Core\TemplateMap;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
interface DocBlock
{
    public function methods(ReflectionClassLike $declaringClass) : ReflectionMethodCollection;
    public function properties(ReflectionClassLike $declaringClass) : ReflectionPropertyCollection;
    public function isDefined() : bool;
    public function raw() : string;
    public function formatted() : string;
    public function returnType() : Type;
    public function methodType(string $methodName) : Type;
    public function propertyType(string $methodName) : Type;
    public function parameterType(string $paramName) : Type;
    public function vars() : DocBlockVars;
    public function params() : DocBlockParams;
    public function inherits() : bool;
    public function deprecation() : Deprecation;
    public function templateMap() : TemplateMap;
    /**
     * @return Type[]
     */
    public function extends() : array;
    /**
     * @return Type[]
     */
    public function implements() : array;
    /**
     * @return Type[]
     */
    public function mixins() : array;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\DocBlock\\DocBlock', 'Phpactor\\WorseReflection\\Core\\DocBlock\\DocBlock', \false);
