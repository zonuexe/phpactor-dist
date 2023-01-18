<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\DocBlock;

use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionScope;
interface DocBlockFactory
{
    public function create(string $docblock, ReflectionScope $scope) : DocBlock;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\DocBlock\\DocBlockFactory', 'Phpactor\\WorseReflection\\Core\\DocBlock\\DocBlockFactory', \false);
