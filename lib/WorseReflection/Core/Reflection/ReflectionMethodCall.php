<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection;

use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
use Phpactor202301\Phpactor\WorseReflection\Core\Position;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionArgumentCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
interface ReflectionMethodCall extends ReflectionNode
{
    public function position() : Position;
    public function class() : ReflectionClassLike;
    public function name() : string;
    public function nameRange() : ByteOffsetRange;
    public function isStatic() : bool;
    public function arguments() : ReflectionArgumentCollection;
    public function inferredReturnType() : Type;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionMethodCall', 'Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionMethodCall', \false);
