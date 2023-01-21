<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

/**
 * @extends Collection<Line>
 */
class Lines extends \Phpactor\CodeBuilder\Domain\Prototype\Collection
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
