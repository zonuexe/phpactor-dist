<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
interface IterableType
{
    public function iterableValueType() : Type;
    public function iterableKeyType() : Type;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\IterableType', 'Phpactor\\WorseReflection\\Core\\Type\\IterableType', \false);
