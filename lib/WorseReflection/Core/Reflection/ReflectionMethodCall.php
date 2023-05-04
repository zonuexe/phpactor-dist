<?php

namespace Phpactor\WorseReflection\Core\Reflection;

use Phpactor\TextDocument\ByteOffsetRange;
use Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionArgumentCollection;
use Phpactor\WorseReflection\Core\Type;
interface ReflectionMethodCall extends \Phpactor\WorseReflection\Core\Reflection\ReflectionNode
{
    public function position() : ByteOffsetRange;
    public function class() : \Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
    public function name() : string;
    public function nameRange() : ByteOffsetRange;
    public function isStatic() : bool;
    public function arguments() : ReflectionArgumentCollection;
    public function inferredReturnType() : Type;
}
