<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain\Refactor;

use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
interface ExtractExpression
{
    public function canExtractExpression(SourceCode $source, int $offsetStart, ?int $offsetEnd = null) : bool;
    public function extractExpression(SourceCode $source, int $offsetStart, int $offsetEnd = null, string $variableName) : TextEdits;
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\Refactor\\ExtractExpression', 'Phpactor\\CodeTransform\\Domain\\Refactor\\ExtractExpression', \false);
