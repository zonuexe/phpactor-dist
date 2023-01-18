<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection;

use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClass as PhpactorReflectionClass;
/**
 * @extends AbstractReflectionCollection<PhpactorReflectionClass>
 */
final class ReflectionClassCollection extends AbstractReflectionCollection
{
    public function concrete() : self
    {
        return new static(\array_filter($this->items, function ($item) {
            return $item->isConcrete();
        }));
    }
}
/**
 * @extends AbstractReflectionCollection<PhpactorReflectionClass>
 */
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\Collection\\ReflectionClassCollection', 'Phpactor\\WorseReflection\\Core\\Reflection\\Collection\\ReflectionClassCollection', \false);
