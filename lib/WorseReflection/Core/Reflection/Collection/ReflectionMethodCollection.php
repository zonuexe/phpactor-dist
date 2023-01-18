<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection;

use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMethod as CoreReflectionMethod;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMethodCollection as CoreReflectionMethodCollection;
/**
 * @extends HomogeneousReflectionMemberCollection<CoreReflectionMethod>
 */
class ReflectionMethodCollection extends HomogeneousReflectionMemberCollection
{
    /**
     * @param CoreReflectionMethod[] $methods
     */
    public static function fromReflectionMethods(array $methods) : CoreReflectionMethodCollection
    {
        $items = [];
        foreach ($methods as $method) {
            $items[$method->name()] = $method;
        }
        return new self($items);
    }
    public function abstract() : CoreReflectionMethodCollection
    {
        return new self(\array_filter($this->items, function (CoreReflectionMethod $item) {
            return $item->isAbstract();
        }));
    }
}
/**
 * @extends HomogeneousReflectionMemberCollection<CoreReflectionMethod>
 */
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\Collection\\ReflectionMethodCollection', 'Phpactor\\WorseReflection\\Core\\Reflection\\Collection\\ReflectionMethodCollection', \false);
