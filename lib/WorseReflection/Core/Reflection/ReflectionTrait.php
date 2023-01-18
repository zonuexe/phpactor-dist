<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Core\DocBlock\DocBlock;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionPropertyCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionTraitCollection;
interface ReflectionTrait extends ReflectionClassLike
{
    public function docblock() : DocBlock;
    public function properties() : ReflectionPropertyCollection;
    public function traits() : ReflectionTraitCollection;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionTrait', 'Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionTrait', \false);
