<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerWorseReflection\Tests\Benchmark;

use Phpactor202301\PhpBench\Benchmark\Metadata\Annotations\OutputTimeUnit;
use Phpactor202301\PhpBench\Benchmark\Metadata\Annotations\Revs;
use Phpactor202301\Phpactor\Extension\LanguageServerCompletion\Tests\IntegrationTestCase;
use Phpactor202301\Phpactor\LanguageServer\Test\LanguageServerTester;
use Phpactor202301\PhpBench\Benchmark\Metadata\Annotations\ParamProviders;
use Generator;
/**
 * @BeforeMethods({"setUp"})
 * @OutputTimeUnit("milliseconds")
 */
class WorkspaceIndexBench extends IntegrationTestCase
{
    private LanguageServerTester $tester;
    public function setUp() : void
    {
        $this->tester = $this->createTester();
        $this->tester->initialize();
        $this->tester->textDocument()->open('file:///foobar', '');
    }
    /**
     * @ParamProviders({"provideUpdate"})
     * @Revs(10)
     * @Iterations(10)
     */
    public function benchUpdate(array $params) : void
    {
        $this->tester->textDocument()->update('file:///foobar', $params['text']);
    }
    public function provideUpdate() : Generator
    {
        $source = \mb_str_split((string) \file_get_contents(__DIR__ . '/source/source.php.example'), 1);
        $buffer = '';
        foreach ($source as $index => $char) {
            $buffer .= $char;
            if (0 === $index % 1000) {
                (yield 'length: ' . \strlen($buffer) => ['text' => $buffer]);
            }
        }
    }
}
/**
 * @BeforeMethods({"setUp"})
 * @OutputTimeUnit("milliseconds")
 */
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerWorseReflection\\Tests\\Benchmark\\WorkspaceIndexBench', 'Phpactor\\Extension\\LanguageServerWorseReflection\\Tests\\Benchmark\\WorkspaceIndexBench', \false);
