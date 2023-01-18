<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference;

use Phpactor202301\Microsoft\PhpParser\Node;
/**
 * Frame walkers can manipulate a frame.
 *
 * Use this extension point to maniputlate types.
 */
interface Walker
{
    /**
     * Return a list of node FQNs that are accepted by this walker or an empty
     * array to accept all nodes.
     *
     * @return class-string[]
     */
    public function nodeFqns() : array;
    public function enter(FrameResolver $resolver, Frame $frame, Node $node) : Frame;
    public function exit(FrameResolver $resolver, Frame $frame, Node $node) : Frame;
}
/**
 * Frame walkers can manipulate a frame.
 *
 * Use this extension point to maniputlate types.
 */
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\Walker', 'Phpactor\\WorseReflection\\Core\\Inference\\Walker', \false);
