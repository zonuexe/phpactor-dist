<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast;

use ArrayIterator;
use Countable;
use Generator;
use IteratorAggregate;
use Phpactor202301\Phpactor\DocblockParser\Ast\Tag\ParameterTag;
/**
 * @implements IteratorAggregate<ParameterTag|Token>
 */
class ParameterList extends Node implements IteratorAggregate, Countable
{
    protected const CHILD_NAMES = ['list'];
    /**
     * @param array<ParameterTag|Token> $list
     */
    public function __construct(public array $list)
    {
    }
    /**
     * @return Generator<ParameterTag>
     */
    public function parameters() : Generator
    {
        foreach ($this->list as $element) {
            if ($element instanceof ParameterTag) {
                (yield $element);
            }
        }
    }
    /**
     * @return ArrayIterator<int, ParameterTag|Token>
     */
    public function getIterator() : ArrayIterator
    {
        return new ArrayIterator($this->list);
    }
    public function count() : int
    {
        return \count($this->list);
    }
}
/**
 * @implements IteratorAggregate<ParameterTag|Token>
 */
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\ParameterList', 'Phpactor\\DocblockParser\\Ast\\ParameterList', \false);
