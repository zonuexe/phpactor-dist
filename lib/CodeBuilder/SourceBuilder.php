<?php

namespace Phpactor202301\Phpactor\CodeBuilder;

use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Renderer;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Updater;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Code;
class SourceBuilder
{
    public function __construct(private Renderer $generator, private Updater $updater)
    {
    }
    public function render(Prototype\Prototype $prototype)
    {
        return $this->generator->render($prototype);
    }
    public function apply(Prototype\Prototype $prototype, Code $code)
    {
        return $this->updater->textEditsFor($prototype, $code)->apply($code);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\SourceBuilder', 'Phpactor\\CodeBuilder\\SourceBuilder', \false);
