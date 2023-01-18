<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Benchmark\Bridge\TolerantParser\WorseReflection;

use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\WorseReflection\Helper\VariableCompletionHelper;
use Phpactor202301\Phpactor\Completion\Core\Formatter\ObjectFormatter;
use Phpactor202301\Phpactor\Completion\Tests\Benchmark\Bridge\TolerantParser\TolerantCompletorBenchCase;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\WorseReflection\WorseLocalVariableCompletor;
class WorseLocalVariableCompletorBench extends TolerantCompletorBenchCase
{
    protected function createTolerant(string $source) : TolerantCompletor
    {
        $reflector = ReflectorBuilder::create()->addSource($source)->build();
        return new WorseLocalVariableCompletor(new VariableCompletionHelper($reflector), new ObjectFormatter());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Benchmark\\Bridge\\TolerantParser\\WorseReflection\\WorseLocalVariableCompletorBench', 'Phpactor\\Completion\\Tests\\Benchmark\\Bridge\\TolerantParser\\WorseReflection\\WorseLocalVariableCompletorBench', \false);
