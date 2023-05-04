<?php

namespace Phpactor\WorseReflection\Core\Reflection;

use Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor\WorseReflection\Core\Inference\NodeContext;
interface ReflectionOffset
{
    public static function fromFrameAndSymbolContext(Frame $frame, NodeContext $nodeContext) : \Phpactor\WorseReflection\Core\Reflection\ReflectionOffset;
    public function frame() : Frame;
    public function nodeContext() : NodeContext;
}
