<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Benchmark\Bridge\TolerantParser\WorseReflection;

use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor;
use Phpactor202301\Phpactor\Completion\Core\Formatter\ObjectFormatter;
use Phpactor202301\Phpactor\Completion\Tests\Benchmark\Bridge\TolerantParser\TolerantCompletorBenchCase;
use Phpactor202301\Phpactor\ObjectRenderer\ObjectRendererBuilder;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\WorseReflection\WorseClassMemberCompletor;
class ClassMemberCompletorBench extends TolerantCompletorBenchCase
{
    protected function createTolerant(string $source) : TolerantCompletor
    {
        $reflector = ReflectorBuilder::create()->addSource($source)->build();
        return new WorseClassMemberCompletor($reflector, new ObjectFormatter(), new ObjectFormatter(), ObjectRendererBuilder::create()->build());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Benchmark\\Bridge\\TolerantParser\\WorseReflection\\ClassMemberCompletorBench', 'Phpactor\\Completion\\Tests\\Benchmark\\Bridge\\TolerantParser\\WorseReflection\\ClassMemberCompletorBench', \false);
