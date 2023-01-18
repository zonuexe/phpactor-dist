<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain\DocBlockUpdater;

use Phpactor202301\Phpactor\DocblockParser\Ast\TagNode;
interface TagPrototype
{
    public function matches(TagNode $tag) : bool;
    public function endOffsetFor(TagNode $tag) : int;
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\DocBlockUpdater\\TagPrototype', 'Phpactor\\CodeTransform\\Domain\\DocBlockUpdater\\TagPrototype', \false);
