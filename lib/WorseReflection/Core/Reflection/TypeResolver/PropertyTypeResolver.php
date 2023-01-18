<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection\TypeResolver;

use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionPromotedProperty;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionProperty;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
class PropertyTypeResolver
{
    public function __construct(private ReflectionProperty $property)
    {
    }
    public function resolve() : Type
    {
        $docblockType = $this->getDocblockType();
        if (\false === $docblockType->isDefined()) {
            $docblockType = $this->getDocblockTypesFromClass();
        }
        if ($docblockType->isDefined()) {
            return $docblockType;
        }
        if ($this->property instanceof ReflectionPromotedProperty) {
            $paramType = $this->property->class()->methods()->get('__construct')->docblock()->parameterType($this->property->name());
            if ($paramType->isDefined()) {
                return $paramType;
            }
        }
        return $this->property->type();
    }
    private function getDocblockType() : Type
    {
        return $this->property->docblock()->vars()->type();
    }
    private function getDocblockTypesFromClass() : Type
    {
        return $this->property->class()->docblock()->propertyType($this->property->name());
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\TypeResolver\\PropertyTypeResolver', 'Phpactor\\WorseReflection\\Core\\Reflection\\TypeResolver\\PropertyTypeResolver', \false);
