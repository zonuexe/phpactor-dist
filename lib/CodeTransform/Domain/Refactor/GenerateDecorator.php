<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain\Refactor;

use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
interface GenerateDecorator
{
    public function getTextEdits(SourceCode $source, string $interface) : TextEdits;
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\Refactor\\GenerateDecorator', 'Phpactor\\CodeTransform\\Domain\\Refactor\\GenerateDecorator', \false);
