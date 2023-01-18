<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Tests\Adapter\Twig;

use Phpactor202301\Phpactor\CodeBuilder\Tests\Adapter\GeneratorTestCase;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Renderer;
use Phpactor202301\Phpactor\CodeBuilder\Adapter\Twig\TwigRenderer;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Builder\SourceCodeBuilder;
class TwigGeneratorTest extends GeneratorTestCase
{
    /**
     * @testdox It should fallback to the default templates if variant template
     *          does not exist.
     */
    public function testFallback() : void
    {
        $builder = SourceCodeBuilder::create();
        $source = $this->renderer()->render($builder->build(), 'unknown');
        $this->assertEquals('<?php', (string) $source);
    }
    protected function renderer() : Renderer
    {
        static $generator;
        if ($generator) {
            return $generator;
        }
        $generator = new TwigRenderer();
        return $generator;
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Tests\\Adapter\\Twig\\TwigGeneratorTest', 'Phpactor\\CodeBuilder\\Tests\\Adapter\\Twig\\TwigGeneratorTest', \false);
