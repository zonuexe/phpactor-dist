<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain\DocBlockUpdater;

use Phpactor202301\Phpactor\DocblockParser\Ast\TagNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\Tag\ReturnTag;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
class ReturnTagPrototype implements TagPrototype
{
    public function __construct(public Type $type)
    {
    }
    public function matches(TagNode $tag) : bool
    {
        return $tag instanceof ReturnTag;
    }
    public function endOffsetFor(TagNode $tag) : int
    {
        \assert($tag instanceof ReturnTag);
        return $tag->type() ? $tag->type()->end() : $tag->end();
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\DocBlockUpdater\\ReturnTagPrototype', 'Phpactor\\CodeTransform\\Domain\\DocBlockUpdater\\ReturnTagPrototype', \false);
