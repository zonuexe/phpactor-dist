<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Core\Position;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\DocBlock\DocBlock;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\NodeText;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionParameterCollection;
interface ReflectionFunctionLike
{
    /**
     * @return ReflectionParameterCollection<ReflectionParameter>
     */
    public function parameters() : ReflectionParameterCollection;
    public function body() : NodeText;
    public function position() : Position;
    public function frame() : Frame;
    public function docblock() : DocBlock;
    public function scope() : ReflectionScope;
    public function inferredType() : Type;
    public function type() : Type;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionFunctionLike', 'Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionFunctionLike', \false);
