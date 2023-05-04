<?php

namespace Phpactor\WorseReflection\Core\Reflection;

use Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionArgumentCollection;
use Phpactor\TextDocument\ByteOffsetRange;
interface ReflectionObjectCreationExpression extends \Phpactor\WorseReflection\Core\Reflection\ReflectionNode
{
    public function position() : ByteOffsetRange;
    public function class() : \Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
    public function arguments() : ReflectionArgumentCollection;
}
