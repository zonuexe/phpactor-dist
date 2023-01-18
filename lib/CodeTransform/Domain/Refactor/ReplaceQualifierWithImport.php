<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain\Refactor;

use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\TextDocument\TextDocumentEdits;
interface ReplaceQualifierWithImport
{
    public function getTextEdits(SourceCode $sourceCode, int $offset) : TextDocumentEdits;
    public function canReplaceWithImport(SourceCode $sourceCode, int $offset) : bool;
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\Refactor\\ReplaceQualifierWithImport', 'Phpactor\\CodeTransform\\Domain\\Refactor\\ReplaceQualifierWithImport', \false);
