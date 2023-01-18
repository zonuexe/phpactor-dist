<?php

namespace Phpactor202301\Phpactor\CodeTransform\Adapter\Native\GenerateNew;

use Phpactor202301\Phpactor\CodeTransform\Domain\GenerateNew;
use Phpactor202301\Phpactor\CodeTransform\Domain\ClassName;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Builder\SourceCodeBuilder;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Renderer;
class ClassGenerator implements GenerateNew
{
    public function __construct(private Renderer $renderer, private ?string $variant = null)
    {
    }
    public function generateNew(ClassName $targetName) : SourceCode
    {
        $builder = SourceCodeBuilder::create();
        $builder->namespace($targetName->namespace());
        $classPrototype = $builder->class($targetName->short());
        return SourceCode::fromString((string) $this->renderer->render($builder->build(), $this->variant));
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Adapter\\Native\\GenerateNew\\ClassGenerator', 'Phpactor\\CodeTransform\\Adapter\\Native\\GenerateNew\\ClassGenerator', \false);
