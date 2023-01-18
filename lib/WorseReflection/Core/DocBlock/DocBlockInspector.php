<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\DocBlock;

interface DocBlockInspector
{
    public function typesForMethod(string $docblock, string $methodName) : array;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\DocBlock\\DocBlockInspector', 'Phpactor\\WorseReflection\\Core\\DocBlock\\DocBlockInspector', \false);
