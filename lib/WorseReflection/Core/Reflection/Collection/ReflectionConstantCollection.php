<?php

namespace Phpactor\WorseReflection\Core\Reflection\Collection;

use Phpactor\WorseReflection\Core\Reflection\ReflectionConstant as CoreReflectionConstant;
/**
 * @extends HomogeneousReflectionMemberCollection<CoreReflectionConstant>
 */
class ReflectionConstantCollection extends \Phpactor\WorseReflection\Core\Reflection\Collection\HomogeneousReflectionMemberCollection
{
    /**
     * @param CoreReflectionConstant[] $constants
     */
    public static function fromReflectionConstants(array $constants) : self
    {
        return new self($constants);
    }
}
