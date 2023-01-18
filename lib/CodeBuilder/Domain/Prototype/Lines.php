<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype;

/**
 * @extends Collection<Line>
 */
class Lines extends Collection
{
    public function __toString()
    {
        return \implode(\PHP_EOL, $this->items);
    }
    public static function fromLines(array $lines)
    {
        return new self($lines);
    }
    protected function singularName() : string
    {
        return 'line';
    }
}
/**
 * @extends Collection<Line>
 */
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Prototype\\Lines', 'Phpactor\\CodeBuilder\\Domain\\Prototype\\Lines', \false);
