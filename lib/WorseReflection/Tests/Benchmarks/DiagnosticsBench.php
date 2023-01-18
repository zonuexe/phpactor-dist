<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Benchmarks;

use Generator;
use GlobIterator;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics\MissingMethodProvider;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
use SplFileInfo;
/**
 * @Iterations(5)
 * @Revs(1)
 */
class DiagnosticsBench
{
    private Reflector $reflector;
    public function init() : void
    {
        $this->reflector = ReflectorBuilder::create()->addDiagnosticProvider(new MissingMethodProvider())->build();
    }
    /**
     * @BeforeMethods({"init"})
     * @ParamProviders({"providePaths"})
     * @param array{path:string} $params
     */
    public function benchDiagnostics(array $params) : void
    {
        $diagnostics = $this->reflector->diagnostics((string) \file_get_contents($params['path']));
    }
    /**
     * @return Generator<array{path:string}>
     */
    public function providePaths() : Generator
    {
        foreach (new GlobIterator(__DIR__ . '/fixtures/diagnostics/*.test') as $info) {
            \assert($info instanceof SplFileInfo);
            (yield $info->getFilename() => ['path' => $info->getRealPath()]);
        }
    }
}
/**
 * @Iterations(5)
 * @Revs(1)
 */
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Benchmarks\\DiagnosticsBench', 'Phpactor\\WorseReflection\\Tests\\Benchmarks\\DiagnosticsBench', \false);
