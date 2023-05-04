<?php

namespace Phpactor\CodeBuilder\Domain\Builder;

use Phpactor\CodeBuilder\Domain\Prototype\Line;
use Phpactor\CodeBuilder\Domain\Prototype\MethodBody;
class MethodBodyBuilder
{
    /**
     * @var Line[]
     */
    protected array $lines = [];
    public function __construct(private \Phpactor\CodeBuilder\Domain\Builder\MethodBuilder $parent)
    {
    }
    public function line(string $text) : \Phpactor\CodeBuilder\Domain\Builder\MethodBodyBuilder
    {
        $this->lines[] = Line::fromString($text);
        return $this;
    }
    public function build() : MethodBody
    {
        return MethodBody::fromLines($this->lines);
    }
    public function end() : \Phpactor\CodeBuilder\Domain\Builder\MethodBuilder
    {
        return $this->parent;
    }
}
