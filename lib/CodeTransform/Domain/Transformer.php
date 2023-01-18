<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain;

use Phpactor202301\Phpactor\TextDocument\TextEdits;
interface Transformer
{
    public function transform(SourceCode $code) : TextEdits;
    /**
     * Return the issues that this transform will fix.
     */
    public function diagnostics(SourceCode $code) : Diagnostics;
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\Transformer', 'Phpactor\\CodeTransform\\Domain\\Transformer', \false);
