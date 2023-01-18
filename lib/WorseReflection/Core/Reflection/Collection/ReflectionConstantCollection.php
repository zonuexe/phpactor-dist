<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection;

use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionConstant as CoreReflectionConstant;
/**
 * @extends HomogeneousReflectionMemberCollection<CoreReflectionConstant>
 */
class ReflectionConstantCollection extends HomogeneousReflectionMemberCollection
{
    /**
     * @param CoreReflectionConstant[] $constants
     */
    public static function fromReflectionConstants(array $constants) : self
    {
        return new self($constants);
    }
}
/**
 * @extends HomogeneousReflectionMemberCollection<CoreReflectionConstant>
 */
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\Collection\\ReflectionConstantCollection', 'Phpactor\\WorseReflection\\Core\\Reflection\\Collection\\ReflectionConstantCollection', \false);
