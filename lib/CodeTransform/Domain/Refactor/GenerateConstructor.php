<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain\Refactor;

use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\WorkspaceEdits;
interface GenerateConstructor
{
    public function generateMethod(TextDocument $document, ByteOffset $offset) : WorkspaceEdits;
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\Refactor\\GenerateConstructor', 'Phpactor\\CodeTransform\\Domain\\Refactor\\GenerateConstructor', \false);
