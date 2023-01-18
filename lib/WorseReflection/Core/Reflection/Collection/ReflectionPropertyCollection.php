<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection;

use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionProperty as PhpactorReflectionProperty;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionPropertyCollection as CoreReflectionPropertyCollection;
/**
 * @extends HomogeneousReflectionMemberCollection<PhpactorReflectionProperty>
 */
final class ReflectionPropertyCollection extends HomogeneousReflectionMemberCollection
{
    /**
     * @param PhpactorReflectionProperty[] $properties
     */
    public static function fromReflectionProperties(array $properties) : CoreReflectionPropertyCollection
    {
        $items = [];
        foreach ($properties as $property) {
            $items[$property->name()] = $property;
        }
        return new self($items);
    }
}
/**
 * @extends HomogeneousReflectionMemberCollection<PhpactorReflectionProperty>
 */
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\Collection\\ReflectionPropertyCollection', 'Phpactor\\WorseReflection\\Core\\Reflection\\Collection\\ReflectionPropertyCollection', \false);
