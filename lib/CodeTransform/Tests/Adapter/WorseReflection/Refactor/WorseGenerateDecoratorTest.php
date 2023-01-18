<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\Refactor;

use Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\Refactor\WorseGenerateDecorator;
use Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\WorseTestCase;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
class WorseGenerateDecoratorTest extends WorseTestCase
{
    /**
     * @dataProvider provideDector
     */
    public function testGenerateDecorator(string $test) : void
    {
        [$source, $expected, $offset] = $this->sourceExpectedAndOffset(__DIR__ . '/fixtures/' . $test);
        $sourceCode = SourceCode::fromStringAndPath($source, 'file:///source');
        $generateDecorator = new WorseGenerateDecorator($this->reflectorForWorkspace($source), $this->updater());
        $textDocumentEdits = $generateDecorator->getTextEdits($sourceCode, 'Phpactor202301\\Phpactor\\SomethingToDecorate');
        $transformed = SourceCode::fromStringAndPath((string) $textDocumentEdits->apply($sourceCode), 'file:///source');
        $this->assertEquals(\trim($expected), \trim($transformed));
    }
    /**
     * @return array<string,array{string}>
     */
    public function provideDector() : array
    {
        return ['decorating untyped method' => ['generateDecorator1.test'], 'decorating method with parameters' => ['generateDecorator2.test'], 'decorating method with return type' => ['generateDecorator3.test'], 'decorating method with default values' => ['generateDecorator4.test'], 'decorating method with void' => ['generateDecorator5.test'], 'decorating multiple methods' => ['generateDecorator6.test']];
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\Refactor\\WorseGenerateDecoratorTest', 'Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\Refactor\\WorseGenerateDecoratorTest', \false);
