<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain\Refactor;

use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
interface FillObject
{
    public function fillObject(TextDocument $document, ByteOffset $offset) : TextEdits;
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\Refactor\\FillObject', 'Phpactor\\CodeTransform\\Domain\\Refactor\\FillObject', \false);
