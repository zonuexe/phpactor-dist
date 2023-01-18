<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype;

/**
 * @extends Collection<UseStatement>
 */
class UseStatements extends Collection
{
    public static function fromUseStatements(array $useStatements)
    {
        return new self($useStatements);
    }
    public function sorted() : UseStatements
    {
        $items = \iterator_to_array($this);
        \usort($items, function (UseStatement $left, UseStatement $right) : int {
            return \strcmp((string) $left, $right);
        });
        return new self($items);
    }
    protected function singularName() : string
    {
        return 'use statement';
    }
}
/**
 * @extends Collection<UseStatement>
 */
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Prototype\\UseStatements', 'Phpactor\\CodeBuilder\\Domain\\Prototype\\UseStatements', \false);
