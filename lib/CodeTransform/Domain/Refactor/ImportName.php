<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain\Refactor;

use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\ImportClass\NameImport;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
interface ImportName
{
    public function importName(SourceCode $source, ByteOffset $offset, NameImport $nameImport) : TextEdits;
    /**
     * Implementers must provide text edits for the import only without updating references.
     */
    public function importNameOnly(SourceCode $source, ByteOffset $offset, NameImport $nameImport) : TextEdits;
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\Refactor\\ImportName', 'Phpactor\\CodeTransform\\Domain\\Refactor\\ImportName', \false);
