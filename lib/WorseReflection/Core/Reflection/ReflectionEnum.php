<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Core\DocBlock\DocBlock;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionEnumCaseCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionPropertyCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
interface ReflectionEnum extends ReflectionClassLike
{
    public function docblock() : DocBlock;
    public function properties() : ReflectionPropertyCollection;
    public function cases() : ReflectionEnumCaseCollection;
    public function isBacked() : bool;
    public function backedType() : Type;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionEnum', 'Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionEnum', \false);
