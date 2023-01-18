<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Core\DocBlock\DocBlock;
use Phpactor202301\Phpactor\WorseReflection\Core\Name;
use Phpactor202301\Phpactor\WorseReflection\Core\Position;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
interface ReflectionDeclaredConstant
{
    public function name() : Name;
    public function type() : Type;
    public function sourceCode() : SourceCode;
    public function docblock() : DocBlock;
    public function position() : Position;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionDeclaredConstant', 'Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionDeclaredConstant', \false);
