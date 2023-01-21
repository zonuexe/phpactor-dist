<?php

namespace Phpactor\CodeTransform\Domain;

use Phpactor\TextDocument\TextEdits;
interface Transformer
{
    public function transform(\Phpactor\CodeTransform\Domain\SourceCode $code) : TextEdits;
    /**
     * Return the issues that this transform will fix.
     */
    public function diagnostics(\Phpactor\CodeTransform\Domain\SourceCode $code) : \Phpactor\CodeTransform\Domain\Diagnostics;
}
