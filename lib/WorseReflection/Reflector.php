<?php

namespace Phpactor202301\Phpactor\WorseReflection;

use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\ConstantReflector;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\FunctionReflector;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\ClassReflector;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\SourceCodeReflector;
interface Reflector extends ClassReflector, SourceCodeReflector, FunctionReflector, ConstantReflector
{
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Reflector', 'Phpactor\\WorseReflection\\Reflector', \false);
