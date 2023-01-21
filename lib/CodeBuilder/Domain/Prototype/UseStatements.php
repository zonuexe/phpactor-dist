<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

/**
 * @extends Collection<UseStatement>
 */
class UseStatements extends \Phpactor\CodeBuilder\Domain\Prototype\Collection
{
    public static function fromUseStatements(array $useStatements)
    {
        return new self($useStatements);
    }
    public function sorted() : \Phpactor\CodeBuilder\Domain\Prototype\UseStatements
    {
        $items = \iterator_to_array($this);
        \usort($items, function (\Phpactor\CodeBuilder\Domain\Prototype\UseStatement $left, \Phpactor\CodeBuilder\Domain\Prototype\UseStatement $right) : int {
            return \strcmp((string) $left, $right);
        });
        return new self($items);
    }
    protected function singularName() : string
    {
        return 'use statement';
    }
}
