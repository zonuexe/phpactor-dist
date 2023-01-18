<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain\Refactor;

use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\TextDocument\TextDocumentEdits;
interface GenerateMethod
{
    public function generateMethod(SourceCode $sourceCode, int $offset) : TextDocumentEdits;
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\Refactor\\GenerateMethod', 'Phpactor\\CodeTransform\\Domain\\Refactor\\GenerateMethod', \false);
