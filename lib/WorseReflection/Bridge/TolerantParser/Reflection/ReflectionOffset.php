<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionOffset as CoreReflectionOffset;
final class ReflectionOffset implements CoreReflectionOffset
{
    private function __construct(private Frame $frame, private NodeContext $symbolContext)
    {
    }
    public static function fromFrameAndSymbolContext($frame, $symbolContext)
    {
        return new self($frame, $symbolContext);
    }
    public function frame() : Frame
    {
        return $this->frame;
    }
    public function symbolContext() : NodeContext
    {
        return $this->symbolContext;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionOffset', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionOffset', \false);
