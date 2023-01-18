<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Core\Position;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionClassCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionConstantCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionPropertyCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionInterfaceCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionTraitCollection;
interface ReflectionClass extends ReflectionClassLike
{
    public function isAbstract() : bool;
    public function constants() : ReflectionConstantCollection;
    public function parent() : ?ReflectionClass;
    public function ancestors() : ReflectionClassCollection;
    public function properties(ReflectionClassLike $contextClass = null) : ReflectionPropertyCollection;
    /**
     * @return ReflectionInterfaceCollection<ReflectionInterface>
     */
    public function interfaces() : ReflectionInterfaceCollection;
    public function traits() : ReflectionTraitCollection;
    public function memberListPosition() : Position;
    public function isFinal();
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionClass', 'Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionClass', \false);
