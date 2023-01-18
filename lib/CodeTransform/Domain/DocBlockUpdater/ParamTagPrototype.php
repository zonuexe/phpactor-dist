<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain\DocBlockUpdater;

use Phpactor202301\Phpactor\DocblockParser\Ast\TagNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\Tag\ParamTag;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
class ParamTagPrototype implements TagPrototype
{
    public function __construct(public string $name, public Type $type)
    {
    }
    public function matches(TagNode $tag) : bool
    {
        return $tag instanceof ParamTag && \ltrim($tag->paramName(), '$') === $this->name;
    }
    public function endOffsetFor(TagNode $tag) : int
    {
        \assert($tag instanceof ParamTag);
        return $tag->variable ? $tag->variable->end() : $tag->end();
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\DocBlockUpdater\\ParamTagPrototype', 'Phpactor\\CodeTransform\\Domain\\DocBlockUpdater\\ParamTagPrototype', \false);
