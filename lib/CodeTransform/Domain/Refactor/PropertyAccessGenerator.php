<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain\Refactor;

use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
interface PropertyAccessGenerator
{
    /**
     * @param string[] $propertyNames
     */
    public function generate(SourceCode $sourceCode, array $propertyNames, int $offset) : TextEdits;
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\Refactor\\PropertyAccessGenerator', 'Phpactor\\CodeTransform\\Domain\\Refactor\\PropertyAccessGenerator', \false);
