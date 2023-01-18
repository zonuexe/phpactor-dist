<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Builder;

use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Line;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Lines;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\MethodBody;
class MethodBodyBuilder
{
    /**
     * @var Lines[]
     */
    protected array $lines = [];
    public function __construct(private MethodBuilder $parent)
    {
    }
    public function line(string $text) : MethodBodyBuilder
    {
        $this->lines[] = Line::fromString($text);
        return $this;
    }
    public function build() : MethodBody
    {
        return MethodBody::fromLines($this->lines);
    }
    public function end() : MethodBuilder
    {
        return $this->parent;
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Builder\\MethodBodyBuilder', 'Phpactor\\CodeBuilder\\Domain\\Builder\\MethodBodyBuilder', \false);
