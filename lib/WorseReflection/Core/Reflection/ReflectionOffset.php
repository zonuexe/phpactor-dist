<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
interface ReflectionOffset
{
    public static function fromFrameAndSymbolContext($frame, $symbolInformation);
    public function frame() : Frame;
    public function symbolContext() : NodeContext;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionOffset', 'Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionOffset', \false);
