<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain\Refactor;

use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\TextDocument\TextDocumentEdits;
interface ExtractMethod
{
    public function canExtractMethod(SourceCode $source, int $offsetStart, int $offsetEnd) : bool;
    public function extractMethod(SourceCode $source, int $offsetStart, int $offsetEnd, string $name) : TextDocumentEdits;
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\Refactor\\ExtractMethod', 'Phpactor\\CodeTransform\\Domain\\Refactor\\ExtractMethod', \false);
