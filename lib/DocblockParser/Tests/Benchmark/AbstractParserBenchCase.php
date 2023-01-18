<?php

namespace Phpactor202301\Phpactor\DocblockParser\Tests\Benchmark;

/**
 * @Iterations(33)
 * @Revs(50)
 * @BeforeMethods({"setUp"})
 * @OutputTimeUnit("milliseconds")
 */
abstract class AbstractParserBenchCase
{
    public abstract function setUp() : void;
    public function benchParse() : void
    {
        $doc = <<<'EOT'
/**
 * @param Foobar $foobar
 * @var Foobar $bafoo
 * @param string $baz
 */
EOT;
        $this->parse($doc);
    }
    /**
     * @Revs(5)
     * @Iterations(10)
     */
    public function benchAssert() : void
    {
        $this->parse((string) \file_get_contents(__DIR__ . '/examples/assert.example'));
    }
    public abstract function parse(string $doc) : void;
}
/**
 * @Iterations(33)
 * @Revs(50)
 * @BeforeMethods({"setUp"})
 * @OutputTimeUnit("milliseconds")
 */
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Tests\\Benchmark\\AbstractParserBenchCase', 'Phpactor\\DocblockParser\\Tests\\Benchmark\\AbstractParserBenchCase', \false);
