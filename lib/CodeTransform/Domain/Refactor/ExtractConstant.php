<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain\Refactor;

use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\TextDocument\TextDocumentEdits;
interface ExtractConstant
{
    public function extractConstant(SourceCode $souceCode, int $offset, string $constantName) : TextDocumentEdits;
    public function canExtractConstant(SourceCode $source, int $offset) : bool;
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\Refactor\\ExtractConstant', 'Phpactor\\CodeTransform\\Domain\\Refactor\\ExtractConstant', \false);
