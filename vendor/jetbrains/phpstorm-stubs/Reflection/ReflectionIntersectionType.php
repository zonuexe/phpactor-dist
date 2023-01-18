<?php

namespace Phpactor202301;

use Phpactor202301\JetBrains\PhpStorm\Pure;
/**
 * @since 8.1
 */
class ReflectionIntersectionType extends \ReflectionType
{
    /** @return ReflectionType[] */
    #[Pure]
    public function getTypes() : array
    {
    }
}
/**
 * @since 8.1
 */
\class_alias('Phpactor202301\\ReflectionIntersectionType', 'ReflectionIntersectionType', \false);
