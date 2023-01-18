<?php

namespace Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\Helper;

use Phpactor202301\Phpactor\CodeTransform\Domain\Helper\MissingMethodFinder;
use Phpactor202301\Phpactor\CodeTransform\Domain\Helper\MissingMethodFinder\MissingMethod;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics\MissingMethodDiagnostic;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
class WorseMissingMethodFinder implements MissingMethodFinder
{
    public function __construct(private Reflector $reflector)
    {
    }
    public function find(TextDocument $sourceCode) : array
    {
        $diagnostics = $this->reflector->diagnostics($sourceCode)->byClass(MissingMethodDiagnostic::class);
        $missing = [];
        /** @var MissingMethodDiagnostic $missingMethod */
        foreach ($diagnostics as $missingMethod) {
            $missing[] = new MissingMethod($missingMethod->methodName(), $missingMethod->range());
        }
        return $missing;
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Helper\\WorseMissingMethodFinder', 'Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Helper\\WorseMissingMethodFinder', \false);
