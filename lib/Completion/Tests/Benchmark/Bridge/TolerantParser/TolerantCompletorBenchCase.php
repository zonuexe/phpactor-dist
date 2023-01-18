<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Benchmark\Bridge\TolerantParser;

use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\ChainTolerantCompletor;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor;
use Phpactor202301\Phpactor\Completion\Core\Completor;
use Phpactor202301\Phpactor\Completion\Tests\Benchmark\CompletorBenchCase;
abstract class TolerantCompletorBenchCase extends CompletorBenchCase
{
    protected abstract function createTolerant(string $source) : TolerantCompletor;
    protected function create(string $source) : Completor
    {
        return new ChainTolerantCompletor([$this->createTolerant($source)]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Benchmark\\Bridge\\TolerantParser\\TolerantCompletorBenchCase', 'Phpactor\\Completion\\Tests\\Benchmark\\Bridge\\TolerantParser\\TolerantCompletorBenchCase', \false);
