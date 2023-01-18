<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
interface Concatable
{
    public function concat(Type $right) : Type;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\Concatable', 'Phpactor\\WorseReflection\\Core\\Type\\Concatable', \false);
