<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\Position;
interface ReflectionArgument
{
    public function guessName() : string;
    public function type() : Type;
    public function value();
    public function position() : Position;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionArgument', 'Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionArgument', \false);
