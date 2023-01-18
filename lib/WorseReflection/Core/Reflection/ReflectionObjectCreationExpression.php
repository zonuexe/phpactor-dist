<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionArgumentCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Position;
interface ReflectionObjectCreationExpression extends ReflectionNode
{
    public function position() : Position;
    public function class() : ReflectionClassLike;
    public function arguments() : ReflectionArgumentCollection;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionObjectCreationExpression', 'Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionObjectCreationExpression', \false);
