<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
interface ArrayAccessType
{
    /**
     * @param array-key $offset $offset
     */
    public function typeAtOffset($offset) : Type;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\ArrayAccessType', 'Phpactor\\WorseReflection\\Core\\Type\\ArrayAccessType', \false);
