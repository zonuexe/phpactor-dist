<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
interface InvokeableType
{
    /**
     * @return Type[]
     */
    public function arguments() : array;
    public function returnType() : Type;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\InvokeableType', 'Phpactor\\WorseReflection\\Core\\Type\\InvokeableType', \false);
