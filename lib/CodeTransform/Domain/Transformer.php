<?php

namespace Phpactor\CodeTransform\Domain;

use PhpactorDist\Amp\Promise;
use Phpactor\TextDocument\TextEdits;
interface Transformer
{
    /**
     * @return Promise<TextEdits>
     */
    public function transform(\Phpactor\CodeTransform\Domain\SourceCode $code) : Promise;
    /**
     * Return the issues that this transform will fix.
     * @return Promise<Diagnostics>
     */
    public function diagnostics(\Phpactor\CodeTransform\Domain\SourceCode $code) : Promise;
}
