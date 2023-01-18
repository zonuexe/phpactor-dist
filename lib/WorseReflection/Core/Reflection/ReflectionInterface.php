<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionConstantCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionInterfaceCollection;
interface ReflectionInterface extends ReflectionClassLike
{
    public function constants() : ReflectionConstantCollection;
    public function parents() : ReflectionInterfaceCollection;
    public function isInstanceOf(ClassName $className) : bool;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionInterface', 'Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionInterface', \false);
