<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain\Refactor;

use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
interface OverrideMethod
{
    public function overrideMethod(SourceCode $source, string $className, string $methodName) : string;
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\Refactor\\OverrideMethod', 'Phpactor\\CodeTransform\\Domain\\Refactor\\OverrideMethod', \false);
