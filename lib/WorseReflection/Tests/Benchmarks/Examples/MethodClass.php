<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Benchmarks\Examples;

class MethodClass
{
    public function methodNoReturnType() : void
    {
    }
    public function methodWithReturnType() : MethodClass
    {
    }
    /**
     * @return MethodClass
     */
    public function methodWithDocblockReturnType()
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Benchmarks\\Examples\\MethodClass', 'Phpactor\\WorseReflection\\Tests\\Benchmarks\\Examples\\MethodClass', \false);
