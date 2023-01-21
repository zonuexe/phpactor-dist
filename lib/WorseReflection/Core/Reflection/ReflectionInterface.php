<?php

namespace Phpactor\WorseReflection\Core\Reflection;

use Phpactor\WorseReflection\Core\ClassName;
use Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionConstantCollection;
use Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionInterfaceCollection;
interface ReflectionInterface extends \Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike
{
    public function constants() : ReflectionConstantCollection;
    public function parents() : ReflectionInterfaceCollection;
    public function isInstanceOf(ClassName $className) : bool;
}
