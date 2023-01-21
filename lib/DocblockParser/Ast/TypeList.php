<?php

namespace Phpactor\DocblockParser\Ast;

use ArrayIterator;
use Countable;
use IteratorAggregate;
/**
 * @implements IteratorAggregate<int,Token|Element>
 */
class TypeList extends \Phpactor\DocblockParser\Ast\Node implements IteratorAggregate, Countable
{
    protected const CHILD_NAMES = ['list'];
    /**
     * @param array<Token|TypeNode> $list
     */
    public function __construct(public array $list)
    {
    }
    /**
     * @return ArrayIterator<int, Token|TypeNode>
     */
    public function getIterator() : ArrayIterator
    {
        return new ArrayIterator($this->list);
    }
    public function count() : int
    {
        return \count($this->list);
    }
    public function types() : \Phpactor\DocblockParser\Ast\TypeNodes
    {
        return new \Phpactor\DocblockParser\Ast\TypeNodes(...\array_filter($this->list, function (\Phpactor\DocblockParser\Ast\Element $element) {
            return $element instanceof \Phpactor\DocblockParser\Ast\TypeNode;
        }));
    }
}
